<?php
// /repo/ch03/php8_warn_str_deref_bad_off.php

$obj = new stdClass();
$obj->a = 1;
$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
echo $str[$obj];

// output:
// Warning: Object of class stdClass could not be converted to int in /repo/ch03/php8_warn_str_deref_bad_off.php on line 7
// Fatal error: Uncaught TypeError: Cannot access offset of type stdClass on string in /repo/ch03/php8_warn_str_deref_bad_off.php on line 7
