<?php
$path = realpath(__DIR__ . '/../src');
require $path . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader($path);
return $loader;
