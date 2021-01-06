<?php
// ch04/php8_ffi_cdef.php
// create C data structure
// call a function from libc
// see: https://www.gnu.org/software/libc/manual/html_mono/libc.html

$key  = '';
$size = 4;
$code = <<<EOT
    void srand (unsigned int seed);
    int rand (void);
EOT;
$ffi = FFI::cdef($code, 'libc.so.6');
$ffi->srand(random_int(0, 999));
for ($x = 0; $x < $size; $x++)
    $key .= sprintf('%x', $ffi->rand());
echo "$key\n";
