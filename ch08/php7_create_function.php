<?php
// /repo/ch08/php7_create_function.php

$math = [
    'add' => create_function('$a,$b', 'return $a + $b;'),
    'sub' => create_function('$a,$b', 'return $a - $b;'),
    'mul' => create_function('$a,$b', 'return $a * $b;'),
    'div' => create_function('$a,$b', 'return $a / $b;'),
];
$a = 22;
$b = 7;
echo "$a + $b = " . $math['add']($a, $b) . "\n";
echo "$a - $b = " . $math['sub']($a, $b) . "\n";
echo "$a * $b = " . $math['mul']($a, $b) . "\n";
echo "$a / $b = " . $math['div']($a, $b) . "\n";
