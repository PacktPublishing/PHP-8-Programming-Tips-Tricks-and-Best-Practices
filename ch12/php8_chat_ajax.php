<?php
include __DIR__ . '/vendor/autoload.php';
use Laminas\Diactoros\ServerRequestFactory;
use Chat\Handler\ {GetHandler,PostHandler};
use Chat\Message\Render;
$url = '/ch12/' . basename(__FILE__);
$request = ServerRequestFactory::fromGlobals();
$method = strtolower($request->getMethod());
$response = ($method === 'post')
    ? (new PostHandler())->handle($request)
    : (new GetHandler())->handle($request);
echo Render::output($request, $response);
