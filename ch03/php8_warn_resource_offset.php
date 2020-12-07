<?php
// /repo/ch03/php8_warn_resource_offset.php

$fn = __DIR__ . '/../sample_data/gettysburg.txt';
$fh = fopen($fn, 'r');
echo $fh . "\n";

$arr = [1,2,3,4,5,6,7,8,9,10];
echo $arr[$fh];
