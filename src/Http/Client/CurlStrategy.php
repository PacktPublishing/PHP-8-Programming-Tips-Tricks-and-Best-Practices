<?php
// /repo/src/Http/Client/CurlStrategy.php
namespace Http\Client;
use CurlHandle;
use Http\Request;
class CurlStrategy implements StrategyInterface
{
    // uses constructor argument promotion
    public function __construct(
        public CurlHandle $handle) {}
    // send data
    public function send(Request $request) : string|false
    {
        curl_setopt($this->handle, CURLOPT_URL, $request->url);
        if (strtolower($request->method) === 'post') {
            $opts = [
                CURLOPT_FRESH_CONNECT => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FORBID_REUSE => 1,
                CURLOPT_TIMEOUT => 4,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => http_build_query($request->query),
            ];
            curl_setopt_array($this->handle, $opts);
        }
        if ($request->debug)
            error_log(__METHOD__ . ':' . var_export(curl_getinfo($this->handle), TRUE));
        return curl_exec($this->handle);
    }
}
