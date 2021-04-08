<?php
// /repo/src/Http/Client/SocketStrategy.php
namespace Http\Client;
use SplFileObject;
use Exception;
use Http\Request;
class StreamsStrategy implements StrategyInterface
{
    // uses constructor argument promotion
    public function __construct(
        public ?SplFileObject $obj) {}
    // send data
    public function send(Request $request) : string|false
    {
        $context = NULL;
        if (strtolower($request->method) !== 'post') {
            $this->obj = new SplFileObject($request->url, 'r');
        } else {
            $params = [
                'http' => [
                    'method' => $request->method,
                    'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
                               . "Content-Length: " . strlen($request->query) . "\r\n",
                    'content' => $request->query
                ],
            ];
            $context = stream_context_create($params);
            $this->obj = new SplFileObject($request->url, 'r', FALSE, $context);
        }
        if ($this->obj->valid()) {
            ob_start();
            $this->obj->fpassthru();
            $result = ob_get_contents();
            ob_end_clean();
        } else {
            $result = FALSE;
        }
        return $result;
    }
}
