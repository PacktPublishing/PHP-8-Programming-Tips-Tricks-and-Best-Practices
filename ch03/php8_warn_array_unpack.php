<?php
// /repo/ch03/php8_warn_array_unpack.php

$alpha = range('A','Z');
// produces the last letter
echo array_pop($alpha);

// flatten the array into a string
$alpha = implode('', range('A','Z'));
// produce the last letter
echo $alpha[-1];

// only array and Traversable can be unpacked
echo array_pop($alpha);

// output:
/*
ZZ
Fatal error:  Uncaught TypeError: array_pop(): Argument #1 ($array) must be of type array, string given in /repo/ch03/php8_warn_array_unpack.php:14

 */
