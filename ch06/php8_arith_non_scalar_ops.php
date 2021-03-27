<?php
// /repo/ch06/php8_arith_non_scalar_ops.php

$fn  = __DIR__ . '/../sample_data/gettysburg.txt';
$fh  = fopen($fn, 'r');
$obj = new class() { public $val = 99; };
$arr = [1,2,3];

echo "Adding 99 to a resource\n";
try { var_dump($fh + 99); }
catch (Error $e) { echo $e . "\n"; }

echo "\nAdding 99 to an object\n";
try { var_dump($obj + 99); }
catch (Error $e) { echo $e . "\n"; }

echo "\nPerforming array % 99\n";
try { var_dump($arr % 99); }
catch (Error $e) { echo $e . "\n"; }

echo "\nAdding two arrays\n";
try { var_dump($arr + [99]); }
catch (Error $e) { echo $e . "\n"; }

