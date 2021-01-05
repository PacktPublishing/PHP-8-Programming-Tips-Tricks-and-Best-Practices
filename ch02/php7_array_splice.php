<?php
// /repo/ch02/php7_array_splice.php
$arr  = ['Person', 'Camera', 'TV', 'Woman', 'Man'];
$repl = ['Female', 'Male'];
$tmp  = $arr;
$out  = array_splice($arr, 3, count($arr), $repl);
var_dump($arr);
// note the difference in output:
$arr  = $tmp;
$out  = array_splice($arr, 3, NULL, $repl);
var_dump($arr);
