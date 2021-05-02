<?php
// /repo/ch08/php7_closure_from_callable.php

require __DIR__ . '/../src/Services/HashGen.php';
use Services\HashGen;
$hashGen = new HashGen();

$doMd5 = $hashGen->makeHash('md5');
$text  = 'The quick brown fox jumped over the fence';
echo $doMd5($text) . "\n";
var_dump($doMd5);

$temp = new class() { public $class = 'Anonymous: '; };
$doMd5->bindTo($temp);
echo $doMd5($text) . "\n";
var_dump($doMd5);
