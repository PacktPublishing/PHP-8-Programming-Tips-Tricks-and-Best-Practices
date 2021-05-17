<?php
// /repo/ch07/php7_reflection_usage.php

$target = 'Php7\Reflection\Test';
require_once __DIR__ . '/../src/Server/Autoload/Loader.php';
use Server\Autoload\Loader;
use Services\DocBlockChecker;
$autoload = new Loader();
$checker = new DocBlockChecker($target);
var_dump($checker->check());
