<?php
use Swoole\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;

$server = new Swoole\HTTP\Server('0.0.0.0', 9501);

$server->on('start', function (Server $server) {
    echo 'Swoole http server is started at http://0.0.0.0:9501' . PHP_EOL;
});

$server->on('request', function (Request $request, Response $response) {
    $response->header('Content-Type', 'text/html');
    $response->end('<h1>Hello World</h1>');
});

$server->start();
