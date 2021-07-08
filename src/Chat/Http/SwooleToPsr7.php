<?php
namespace Chat\Http;

use Laminas\Diactoros\ServerRequestFactory;
use Swoole\Http\Request as SwooleRequest;
use Psr\Http\Message\ServerRequestInterface;
class SwooleToPsr7
{
    public static function swooleRequestToServerRequest(SwooleRequest $swoole_request) : ServerRequestInterface
    {
        $vars = get_object_vars($swoole_request);
        // convert build $_SERVER equivalent from Swoole
        $server = [];
        foreach ($vars['header'] as $key => $value) {
            $new_key = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
            $server[$new_key] = $value;
        }
        foreach ($vars['server'] as $key => $value) {
            $new_key = strtoupper(str_replace('-', '_', $key));
            $server[$new_key] = $value;
        }
        return ServerRequestFactory::fromGlobals(
            $server,
            $vars['get'],
            $vars['post'],
            $vars['cookie'],
            $vars['files']);
    }
}

/*
object(Swoole\Http\Request)#11 (8) {
  ["fd"]=>
  int(1)
  ["header"]=>
  array(8) {
    ["host"]=>
    string(16) "172.16.0.88:9501"
    ["user-agent"]=>
    string(76) "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:89.0) Gecko/20100101 Firefox/89.0"
    ["accept"]=>
    string(74) "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,;q=0.8"
    ["accept-language"]=>
    string(14) "en-US,en;q=0.5"
    ["accept-encoding"]=>
    string(13) "gzip, deflate"
    ["connection"]=>
    string(10) "keep-alive"
    ["upgrade-insecure-requests"]=>
    string(1) "1"
    ["cache-control"]=>
    string(9) "max-age=0"
  }
  ["server"]=>
  array(10) {
    ["request_method"]=>
    string(3) "GET"
    ["request_uri"]=>
    string(6) "/all=1"
    ["path_info"]=>
    string(6) "/all=1"
    ["request_time"]=>
    int(1625465936)
    ["request_time_float"]=>
    float(1625465936.404925)
    ["server_protocol"]=>
    string(8) "HTTP/1.1"
    ["server_port"]=>
    int(9501)
    ["remote_port"]=>
    int(46488)
    ["remote_addr"]=>
    string(10) "172.16.0.1"
    ["master_time"]=>
    int(1625465936)
  }
  ["cookie"]=>
  NULL
  ["get"]=>
  NULL
  ["files"]=>
  NULL
  ["post"]=>
  NULL
  ["tmpfiles"]=>
  NULL
}
*/
