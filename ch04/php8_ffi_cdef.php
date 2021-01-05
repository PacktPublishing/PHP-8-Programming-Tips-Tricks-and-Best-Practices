<?php
// ch04/php8_ffi_cdef.php
// create C data structure
// call a function from libc
// see: https://www.gnu.org/software/libc/manual/html_mono/libc.html

$key  = '';
$size = 4;
$seed = FFI::cdef('void srand (unsigned int seed);', 'libc.so.6');
$rand = FFI::cdef('int rand (void);', 'libc.so.6');
$seed->srand(random_int(0, 999));
for ($x = 0; $x < $size; $x++)
    $key .= sprintf('%x', $rand->rand());
echo "$key\n";

