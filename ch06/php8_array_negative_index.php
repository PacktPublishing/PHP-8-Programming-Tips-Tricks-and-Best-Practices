<?php
// /repo/ch06/php8_array_negative_index.php

// works in both PHP 7 and 8
$a = [-3 => 'CCC', -2 => 'BBB', -1 => 'AAA'];
var_dump($a);

// this works differently in PHP 8
$b[-3] = 'CCC';
$b[] = 'BBB';
$b[] = 'AAA';
var_dump($b);
