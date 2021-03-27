<?php
// /repo/ch06/php7_arith_non_scalar_ops.php

$fn  = __DIR__ . '/../sample_data/gettysburg.txt';
$fh  = fopen($fn, 'r');
$obj = new class() { public $val = 99; };
$arr = [1,2,3];

echo "Adding 99 to a resource\n";
var_dump($fh + 99);

echo "\nAdding 99 to an object\n";
var_dump($obj + 99);

echo "\nPerforming array % 99\n";
var_dump($arr % 99);

echo "\nAdding two arrays\n";
var_dump($arr + [99]);

