<?php
// /repo/ch03/php8_error_str_pos.php

$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
echo $str[strpos($str, 'Z', 0)];
echo "\n";
echo $str[strpos($str, 'Z', 27)];
echo "\n";

// output:
/*
Z
Fatal error: Uncaught ValueError: strpos(): Argument #3 ($offset) must be contained
in argument #1 ($haystack) in /repo/ch03/php8_error_str_pos.php on line 7
 */
