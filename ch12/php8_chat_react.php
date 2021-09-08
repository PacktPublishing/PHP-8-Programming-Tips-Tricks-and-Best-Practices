<?php
// /repo/ch12/php8_chat_react.php

// to test: open 2 separate command shells into the php8_tips_php8_1 Docker container
// In the 1st shell: php php8_chat_react.php
// In the 2nd shell: php php8_chat_test.php http://localhost:9501

include __DIR__ . '/vendor/autoload.php';
use Chat\Message\Pipe;
use React\EventLoop\Factory;
use React\Http\Server;
use React\Http\Message\Response as ReactResponse;
use Psr\Http\Message\ServerRequestInterface;

session_start();
$loop = Factory::create();
$server = new Server($loop, function (ServerRequestInterface $request) {
    return new ReactResponse(
        200,
        array(
            'Content-Type' => 'text/plain'
        ),
        Pipe::exec($request)
    );
});
$socket = new React\Socket\Server(9501, $loop);
$server->listen($socket);
echo "Server running at http://locahost:9501\n";
$loop->run();
