<?php
// /repo/ch05/php8_bc_break_scanner.php

function scan_for_classname_constructor(string $contents, array &$message)
{
    // look for classname and method of the same name
    $found  = 0;
    $regex1 = '/class (.+?)\b/';
    preg_match($regex1, $contents, $matches);
    if ($matches[1]) {
        $found += (stripos($contents, 'function ' . $matches[1] . '(') !== FALSE);
        $found += (stripos($contents, 'function ' . $matches[1] . ' (') !== FALSE);
        $found -= (stripos($contents, 'function __construct()') !== FALSE);
    }
    if ($found) {
        $message[] = 'WARNING: contains method same name as class but no __construct() method defined';
    } else {
        $message[] = 'PASSED: this file passed ' . __FUNCTION__;
    }
    return $found;
}

$message = [];
$test    = file_get_contents('php8_bc_break_construct.php');
$found   = scan_for_classname_constructor($test, $message);
echo implode("\n", $message);
echo "\n";
