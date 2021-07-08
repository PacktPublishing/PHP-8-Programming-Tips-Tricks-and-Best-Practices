<?php
// /repo/ch03/php8_warn_array_empty.php

$obj = new stdClass();
$obj->c = 'C';
// can't use an object as an array key
$b = ['A' => 1, 'B' => 2, 'C' => 3];
$message =(empty($b[$obj])) ? 'NOT FOUND' : 'FOUND';
echo "$message\n";

// output:
// Fatal error: Uncaught TypeError: Illegal offset type in isset or empty in /repo/ch03/php8_warn_array_empty.php on line 8
