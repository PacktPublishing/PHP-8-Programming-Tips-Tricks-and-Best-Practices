<?php
// /repo/ch06/php8_null_length_arg.php

$str = 'The quick brown fox jumped over the fence';
$var = 'fox';
$pos = strpos($str, $var);
// NOTE: $len is deliberately undefined
$res = substr($str, $pos, $len);
$fnd = ($res) ? '' : ' NOT';
echo "Result   : $var is$fnd found in the string\n";
echo "Remainder: $res\n";
