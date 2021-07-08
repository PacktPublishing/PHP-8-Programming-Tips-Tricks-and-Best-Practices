<?php
// /repo/ch03/php8_warn_amb_offset.php

$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$ptr = [ NULL, TRUE, 22/7 ];
foreach ($ptr as $key) {
    var_dump($key);
    echo $str[$key];
    echo "\n";
}

// output:
/*
NULL
Warning: String offset cast occurred in /repo/ch03/php8_warn_amb_offset.php on line 8
A
bool(true)
Warning: String offset cast occurred in /repo/ch03/php8_warn_amb_offset.php on line 8
B
double(3.1428571428571)
Warning: String offset cast occurred in /repo/ch03/php8_warn_amb_offset.php on line 8
D
 */
