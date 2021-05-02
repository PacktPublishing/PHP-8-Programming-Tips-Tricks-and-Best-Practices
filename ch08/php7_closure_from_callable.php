<?php
// /repo/ch08/php7_closure_from_callable.php

require __DIR__ . '/../src/Services/HashGen.php';
use Services\HashGen;
$hashGen = new HashGen();
$doMd5 = $hashGen->makeHash('md5');
$doSha = $hashGen->makeHash('sha256');
$text  = 'The quick brown fox jumped over the fence';
echo $doMd5($text) . "\n";
echo $doSha($text) . "\n";

$temp = new class() extends HashGen {
    public $class = 'Anonymous: ';
};

$doMd5->bindTo($temp);
echo $doMd5($text) . "\n";
