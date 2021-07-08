<?php
// /repo/ch03/php8_error_str_empty.php

$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$str[5] = '';
echo $str . "\n";

// output:
// Fatal error: Uncaught Error: Cannot assign an empty string to a string offset in /repo/ch03/php8_error_str_empty.php on line 5
