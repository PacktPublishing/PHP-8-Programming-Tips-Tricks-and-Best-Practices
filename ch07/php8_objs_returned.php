<?php
// /repo/ch07/php8_objs_returned.php
require_once __DIR__ . '/../src/Server/Autoload/Loader.php';
use Server\Autoload\Loader;
$autoload = new Loader();
use Http\Request;
use Http\Client\{CurlStrategy,StreamsStrategy};

$url = 'https://api.unlikelysource.com/api?city=Livonia&country=US';
$request = new Request($url);

echo "StreamsStrategy Results:\n";
$streams  = new StreamsStrategy(NULL);
$response = $streams->send($request);
echo $response;

echo "CurlStrategy Results:\n";
$curl     = new CurlStrategy(curl_init());
$response = $curl->send($request);
echo $response;

