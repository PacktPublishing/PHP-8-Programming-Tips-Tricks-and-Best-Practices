<?php
// /repo/ch03/php8_error_str_pos.php

$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
echo $str[strpos($str, 'Z', 0)];
echo "\n";
echo $str[strpos($str, 'Z', 27)];
echo "\n";
