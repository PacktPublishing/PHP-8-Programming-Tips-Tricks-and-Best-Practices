<?php
// ch04/php8_ffi_typeof.php

// create native C data types
$char = FFI::new("char[6]");

// populate with data
$char = 'ABCDEF';
$arr  = [1,2,3];

// native PHP info methods don't work
echo 'Length of $char is ' . strlen($char);

// determine their type
$type[] = FFI::typeOf($char);
$type[] = FFI::typeOf($arr);
var_dump($type);
