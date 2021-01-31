<?php
// /repo/ch05/php8_bc_break_scanner.php
include __DIR__ . '/../vendor/autoload.php';
use Migration\OopBreakScan;
$message = [];
$test    = file_get_contents('php8_bc_break_construct.php');
$found   = OopBreakScan::scanClassnameConstructor($test, $message);
echo implode("\n", $message);
echo "\n";
