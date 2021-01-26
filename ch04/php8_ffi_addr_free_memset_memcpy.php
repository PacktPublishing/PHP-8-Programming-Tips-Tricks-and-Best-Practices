<?php
// /repo/ch04/php8_ffi_addr_free_memset_memcpy.php
// create C data structure

// initialize array with the letter "A"
$size = 6;
$arr  = FFI::new(FFI::type("char[$size]"));
FFI::memset($arr, 65, $size);
echo FFI::string($arr, $size);
echo "\n";

// create copy
$arr2  = FFI::new(FFI::type("char[$size]"));
FFI::memcpy($arr2, $arr, $size);
echo FFI::string($arr2, $size);
echo "\n";

// create a reference
$ref = FFI::addr($arr);
FFI::memset($ref[0], 66, 6);
echo FFI::string($arr, $size);
echo "\n";

// dump everything
var_dump($ref, $arr, $arr2);

// remove the pointer
FFI::free($ref);
