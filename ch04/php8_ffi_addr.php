<?php
// ch04/php8_ffi_addr.php
// create C data structure

// define output function
$output = function ($arr, $size) {
    for ($x = 0; $x < $size; $x++) echo $arr[$x];
    echo "\n";
};

// initialize array with the letter "A"
$size = 6;
$arr  = FFI::new(FFI::type("char[$size]"));
FFI::memset($arr, 65, $size);
echo $output($arr, $size);

// create a reference
$ref = FFI::addr($arr);
FFI::memset($ref[0], 66, 6);
echo $output($arr, $size);
var_dump($arr, $ref);
