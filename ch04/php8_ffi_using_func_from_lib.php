<?php
// ch04/php8_ffi_using_func_from_lib.php

// show output
function show($label, $arr, $max)
{
    $output = $label . "\n";
    for ($x = 0; $x < $max; $x++)
        $output .= $arr[$x] . ',';
    return substr($output, 0, -1) . "\n";
}

// create definitions
$bubble = FFI::cdef(
    "void bubble_sort(int [], int);",
    "./libbubble.so");

// create FFI\CData array
$max = 16;
$arr = FFI::new('int[' . $max . ']');

// populate array with random values
for ($i = 0; $i < $max; $i++)
    $arr[$i]->cdata = rand(0,9999);

// display before
echo "Before Sort\n";
for ($x = 0; $x < $max; $x++) echo $arr[$x] . "\n";

// perform bubble sort
$bubble->bubble_sort($arr, $max);

// display after
echo "After Sort\n";
for ($x = 0; $x < $max; $x++) echo $arr[$x] . "\n";
