<?php
// /repo/ch02/php8_arrow_func_1.php

// "traditional" anonymous function:
$addOld = function ($a, $b) { return $a + $b; };

// arrow function:
$addNew = fn($a, $b) => $a + $b;

echo "Old: " . $addOld(7, 4) . "\n";
echo "New: " . $addNew(7, 4) . "\n";
