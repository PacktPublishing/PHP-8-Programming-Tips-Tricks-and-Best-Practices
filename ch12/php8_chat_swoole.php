<?php
// /repo/ch12/php8_chat_swoole.php
include __DIR__ . '/vendor/autoload.php';
use Chat\Message\Pipe;
use Chat\Http\SwooleToPsr7;
use Swoole\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;

// disable Xdebug in the php.ini file before running this!
// ;zend_extension=/usr/lib/php/extensions/no-debug-non-zts-20200930/xdebug.so
// otherwise you'll get this Warning:
// Warning: Swoole\Server::start(): Using Xdebug in coroutines is extremely dangerous, please notice that it may lead to coredump!

session_start();
$server = new Swoole\HTTP\Server('0.0.0.0', 9501);

$server->on("start", function (Server $server) {
    echo "Swoole http server is started at http://0.0.0.0:9501\n";
    error_log('Swoole http server is started at http://0.0.0.0:9501');
});

$server->on("request", function (Request $swoole_request, Response $swoole_response) {
    $request  = SwooleToPsr7::swooleRequestToServerRequest($swoole_request);
    $swoole_response->header("Content-Type", "text/plain");
    $response = Pipe::exec($request);
    $swoole_response->end($response);
});

$server->start();

