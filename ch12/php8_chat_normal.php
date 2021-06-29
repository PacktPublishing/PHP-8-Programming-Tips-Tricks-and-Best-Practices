<?php
include __DIR__ . '/vendor/autoload.php';
use Laminas\Diactoros\ServerRequestFactory;
use Chat\Handler\ {GetHandler,PostHandler};
use Chat\Message\Render;
$request = ServerRequestFactory::fromGlobals();
$method = strtolower($request->getMethod());
$response = ($method === 'post')
    ? (new PostHandler())->handle($request)
    : (new GetHandler())->handle($request);
// echo Render::output($response);
$data = $response->getPayload();
$status = $data['status'] ?? 'unknown';
$info   = $data['data']   ?? [];
$user   = $request->getParsedBody()['from'] ?? 'username';
include __DIR__ . '/php8_chat_template.phtml';
