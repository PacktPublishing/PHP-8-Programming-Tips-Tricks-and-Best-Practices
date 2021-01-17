<?php
// ch04/php8_ffi_alignof_sizeof.php

// create
$struct = 'struct Bad { char c; double d; int i; }; '
        . 'struct Good { double d; int i; char c; }; ';
$ffi = FFI::cdef($struct);

$bad = $ffi->new("struct Bad");
$good = $ffi->new("struct Good");
var_dump($bad, $good);

echo "\nBad Alignment:\t" . FFI::alignof($bad);     // 8
echo "\nBad Size:\t" . FFI::sizeof($bad);           // 24
echo "\nGood Alignment:\t" . FFI::alignof($good);   // 8
echo "\nGood Size:\t" . FFI::sizeof($good);         // 16

