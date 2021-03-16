<?php
// /repo/ch06/php8_num_str_handling.php
$test = [
    0 => '111',
    1 => '  111',
    2 => '111  ',
    3 => '111doug'
];
foreach ($test as $key => $val)
    echo $key . ':'
         . var_export($val, TRUE) . "\n";
foreach ($test as $key => $val)
    echo $key . ':'
         . var_export(111 + $val, TRUE) . "\n";
echo "\n";
