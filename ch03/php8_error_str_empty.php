<?php
// /repo/ch03/php8_error_str_empty.php

$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$str[5] = '';
echo $str . "\n";
