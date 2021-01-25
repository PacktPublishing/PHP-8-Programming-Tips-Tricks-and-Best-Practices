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
$max   = 16;
$arr_b = FFI::new('int[' . $max . ']');

// populate array with random values
for ($i = 0; $i < $max; $i++)
    $arr_b[$i]->cdata = rand(0,9999);

// display before
echo show('Before Sort', $arr_b, $max);

// perform bubble sort
$bubble->bubble_sort($arr_b, $max);

// display after
echo show('After Sort', $arr_b, $max);
