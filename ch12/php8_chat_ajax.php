<?php
include __DIR__ . '/vendor/autoload.php';
use Laminas\Diactoros\ServerRequestFactory;
use Chat\Handler\ {GetHandler,PostHandler,NextHandler};
use Chat\Middleware\ {Access,Validate,ValidatePost};
use Chat\Message\Render;
$url      = '/ch12/' . basename(__FILE__);
$request  = ServerRequestFactory::fromGlobals();
$method   = strtolower($request->getMethod());
$dontcare = (new Access())->process($request, new NextHandler());
$response = ($method === 'post')
    ? (new ValidatePost())->process($request, new PostHandler())
    : (new Validate())->process($request, new GetHandler());
echo Render::output($request, $response);
