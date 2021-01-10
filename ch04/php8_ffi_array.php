<?php
// ch04/php8_ffi_array.php
// create C data structure

// long form:
//$type = FFI::arrayType(FFI::type("char"), [3, 3]);
//$arr  = FFI::new($type);

// short syntax:
$arr  = FFI::new(FFI::type("char[3][3]"));

// work with it like with a regular PHP array
$pos   = 0;
$val   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$y_max = count($arr);
for ($y = 0; $y < $y_max; $y++) {
    $x_max = count($arr[$y]);
    for ($x = 0; $x < $x_max; $x++) {
        $arr[$y][$x]->cdata = $val[$pos++];
    }
}
var_dump($arr);

// warning: $arr is *not* an array!
echo implode(',', $arr);
