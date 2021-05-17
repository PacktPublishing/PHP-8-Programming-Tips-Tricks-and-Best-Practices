<?php
// /repo/ch09/php7_oop_diffs_private_method.php
include __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Php7\Encrypt\{Cipher,OpenCipher};
$text = 'Super secret message';

$cipher1 = new Cipher();
echo $cipher1->encode($text);
echo "\n";

$cipher2 = new OpenCipher();
var_dump($cipher2->encode($text));
