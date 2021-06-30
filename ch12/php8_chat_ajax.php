<?php
include __DIR__ . '/vendor/autoload.php';
use Laminas\Diactoros\ServerRequestFactory;
use Chat\Handler\ {GetHandler,PostHandler};
use Chat\Message\ {Validate,ValidatePost};
use Chat\Message\Render;
$url = '/ch12/' . basename(__FILE__);
$request = ServerRequestFactory::fromGlobals();
$method = strtolower($request->getMethod());
$response = ($method === 'post')
    ? (new ValidatePost())->process($request, new PostHandler())
    : (new Validate())->process($request, new GetHandler());
echo Render::output($request, $response);
