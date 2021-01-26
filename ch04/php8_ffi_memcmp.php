<?php
// ch04/php8_ffi_memcmp.php

// create native C data types
$a = FFI::new("char[6]");
$b = FFI::new("char[6]");
$c = FFI::new("char[6]");
$d = FFI::new("char[6]");

// populate with values
$populate = function ($cdata, $start, $offset, $num) {
    // populate with alpha chars
    for ($x = 0; $x < $num; $x++)
        $cdata[$x + $offset] = chr($x + $offset + $start);
    return $cdata;
};

$a = $populate($a, 65, 0, 6);
$b = $populate($b, 65, 0, 3);
$b = $populate($b, 85, 3, 3);
$c = $populate($c, 71, 0, 6);
$d = $populate($d, 71, 0, 6);

// display contents
$patt = "%2s : %6s\n";
printf($patt, '$a', FFI::string($a, 6));
printf($patt, '$b', FFI::string($b, 6));
printf($patt, '$c', FFI::string($c, 6));
printf($patt, '$d', FFI::string($d, 6));
/*
$a : ABCDEF
$b : ABCXYZ
$c : GHIJKL
$d : GHIJKL
*/

// can't compare using PHP <=>
// var_dump($a <=> $b);
// PHP Fatal error:  Uncaught FFI\Exception: Comparison of incompatible C types

// can't compare using PHP strcmp()
// var_dump(strcmp($a,$b));
// PHP Warning:  strcmp() expects parameter 1 to be string, object given

// compare using FFI::memcmp()
echo "\nUsing FFI::memcmp()\n";
$p = "%20s : %2d\n";
printf($p, 'memcmp($a, $b, 6)', FFI::memcmp($a, $b, 6));
printf($p, 'memcmp($c, $a, 6)', FFI::memcmp($c, $a, 6));
printf($p, 'memcmp($c, $d, 6)', FFI::memcmp($c, $d, 6));

// using FFI::memcmp() but not full length
echo "\nUsing FFI::memcmp() but not full length\n";
printf($p, 'memcmp($a, $b, 3)', FFI::memcmp($a, $b, 3));

