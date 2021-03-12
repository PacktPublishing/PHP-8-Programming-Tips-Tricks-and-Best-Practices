<?php
// /repo/ch05/php7_autoload_function.php

function __autoLoad($class) {
    $fn = __DIR__ . '/../src/'
        . str_replace('\\', '/', $class)
        . '.php';
    require_once $fn;
}

use Migration\OopBreakScan;
$contents = file_get_contents(__FILE__);
$message  = [];
OopBreakScan::scanMagicAutoloadFunction($contents, $message);
var_dump($message);
