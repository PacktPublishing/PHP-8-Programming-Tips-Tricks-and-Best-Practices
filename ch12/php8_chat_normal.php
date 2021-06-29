<?php
include __DIR__ . '/vendor/autoload.php';
use Laminas\Diactoros\ServerRequestFactory;
use Chat\Handler\ {GetHandler,PostHandler};
$request = ServerRequestFactory::fromGlobals();
$method = strtolower($request->getMethod());
echo ($method === 'get')
    ? (new GetHandler())->handle($request)
    : (new PostHandler())->handle($request);

