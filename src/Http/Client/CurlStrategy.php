<?php
// /repo/src/Http/Client/CurlStrategy.php
namespace Http\Client;
use CurlHandle;
use Http\Request;
class CurlStrategy implements StrategyInterface
{
    // uses constructor argument promotion
    public function __construct(
        public CurlHandle $ch) {}
    // send data
    public function send(Request $request) : string|false
    {
        if (strtolower($request->method) === 'post') {
            $defaults = [
                CURLOPT_HEADER => 0,
                CURLOPT_URL => $request->url,
                CURLOPT_FRESH_CONNECT => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FORBID_REUSE => 1,
                CURLOPT_TIMEOUT => 4,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => http_build_query($request->query),
            ];
        } else {
            $defaults = [
                CURLOPT_URL => $request->url,
            ];
        }
        curl_setopt_array($this->ch, $defaults);
        if ($request->debug)
            error_log(__METHOD__ . ':' . var_export(curl_getinfo($this->ch), TRUE));
        return curl_exec($this->ch);
    }
}
