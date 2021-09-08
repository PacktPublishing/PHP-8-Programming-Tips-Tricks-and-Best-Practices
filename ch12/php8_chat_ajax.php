<?php
// /repo/ch12/php8_chat_ajax.php

// to test:
// php php8_chat_test.php http://localhost/ch12/php8_chat_ajax.php

include __DIR__ . '/vendor/autoload.php';
use Laminas\Diactoros\ServerRequestFactory;
use Chat\Message\Pipe;
$request  = ServerRequestFactory::fromGlobals();
$response = Pipe::exec($request);
echo $response;
