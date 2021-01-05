<?php
// /repo/ch01/php7_attrib_reflect.php
require_once __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Php7\Image\SingleChar;

$reflect = new ReflectionClass(SingleChar::class);
echo '<pre>' . $reflect . '</pre>';

