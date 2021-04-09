<?php
// /repo/src/Http/Client/SocketStrategy.php
namespace Http\Client;
use Socket;
use Exception;
use Http\Request;
class SocketStrategy implements StrategyInterface
{
    // uses constructor argument promotion
    public function __construct(
        public Socket $socket) {}
    // send data
    public function send(Request $request) : string|false
    {
        $port = (!empty($request->port)) ? (int) $request->port : self::DEFAULT_PORT;
        if (!socket_connect($this->socket, $request->host, $port)) {
            $message = socket_strerror(socket_last_error($this->socket));
            throw new Exception($message);
        }
        $data = json_encode($request->query);
        $result = socket_send($this->socket, $data, strlen($data))
        return ($result) ? "Bytes Sent: $result" : FALSE;
    }
}
