<?php
// ch04/php8_ffi_typeof.php

// create native C data types
$char = FFI::new("char[6]");

// populate with data
for ($x = 0; $x < 6; $x++)
    $char[$x] = chr(65 + $x);

// TypeError:strlen(): Argument #1 ($str) must be of type string, FFI\CData given
try {
    echo 'Length of $char is ' . strlen($char);
} catch (Throwable $t) {
    echo $t::class . ':' . $t->getMessage();
}
echo "\n";

// native PHP info methods don't give accurate information
echo '$char is ' .
    ((ctype_alnum($char)) ? 'alpha' : 'non-alpha');
echo "\n";

// determine the type
$type = FFI::typeOf($char);
var_dump($type);
