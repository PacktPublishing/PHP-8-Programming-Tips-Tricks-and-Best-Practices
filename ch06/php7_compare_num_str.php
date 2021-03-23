<?php
// /repo/ch06/php7_compare_num_str.php

// straight string to numeric comparison
$zero   = 0;
$string = 'ABC';
$result = ($zero == $string) ? 'is' : 'is not';
echo "The value $zero $result the same as $string\n";

// checking for a numeric value in an array containing string data
$array  = [1 => 'A', 2 => 'B', 3 => 'C'];
$result = (in_array($zero, $array)) ? 'is in' : 'is not in';
echo "The value $zero $result\n";
echo var_export($array, TRUE) . "\n";

// comparing a numeric value against a numeric string
$mixed  = '42abc88';
$result = ($mixed == 42) ? 'is' : 'is not';
echo "The value $mixed $result the same as 42\n";

