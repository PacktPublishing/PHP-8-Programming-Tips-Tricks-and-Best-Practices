<?php
// /repo/ch06/php8_compare_num_str.php

$number = 0;
$string = 'ABC';
$result = ($number == $string) ? 'is' : 'is not';
echo "The value $number $result the same as $string\n";

$array  = [1 => 'A', 2 => 'B', 3 => 'C'];
$result = (in_array($number, $array)) ? 'is in' : 'is not in';
echo "The value $number $result\n" . var_export($array, TRUE);

$mixed  = '42abc';
$result = ($mixed == 42) ? 'is' : 'is not';
echo "\nThe value $mixed $result the same as 42\n";
