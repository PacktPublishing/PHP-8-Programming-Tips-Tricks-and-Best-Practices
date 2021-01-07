<?php
// ch04/php8_ffi_memcmp.php

// create native C data types
$a = FFI::new("char[8]");
$b = FFI::new("char[8]");
$c = FFI::new("char[8]");
$d = FFI::new("char[8]");

// populate with values
$a = 'ABCDEFGH';
$b = 'ABCDMNOP';
$c = 'DEFGHIJK';
$d = 'DEFGHIJK';

// compare using PHP <=>
echo "\nUsing <=>\n";
$p = "%20s : %2d\n";
printf($p, '($a <=> $b)', ($a <=> $b));
printf($p, '($c <=> $a)', ($c <=> $a));
printf($p, '($c <=> $d)', ($c <=> $d));

// compare using PHP strcmp()
echo "\nUsing strcmp()\n";
printf($p, 'strcmp($a, $b)', strcmp($a, $b));
printf($p, 'strcmp($c, $a)', strcmp($c, $a));
printf($p, 'strcmp($c, $d)', strcmp($c, $d));

// compare using FFI::memcmp()
echo "\nUsing FFI::memcmp()\n";
printf($p, 'memcmp($a, $b, 8)', FFI::memcmp($a, $b, 8));
printf($p, 'memcmp($c, $a, 8)', FFI::memcmp($c, $a, 8));
printf($p, 'memcmp($c, $d, 8)', FFI::memcmp($c, $d, 8));

// using FFI::memcmp() but not full length
echo "\nUsing FFI::memcmp() but not full length\n";
printf($p, 'memcmp($a, $b, 4)', FFI::memcmp($a, $b, 4));

