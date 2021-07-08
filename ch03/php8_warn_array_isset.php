<?php
// /repo/ch03/php8_warn_array_offset.php

$obj = new stdClass();
// can't use an object as an array key
$b = ['A' => 1, 'B' => 2, 'C' => 3];
unset($b[$obj]);
var_dump($b);

// output:
// Fatal error: Uncaught TypeError: Illegal offset type in unset in /repo/ch03/php8_warn_array_isset.php on line 7
