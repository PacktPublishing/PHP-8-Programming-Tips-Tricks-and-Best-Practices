<?php
// /repo/ch06/php8_printf_vs_vprintf.php

$ord  = 'third';
$day  = 'Thursday';
$pos  = 'next';
$date = new DateTime("$ord $day of $pos month");
$patt = "The %s %s of %s month is: %s\n";

// using printf() with a series of args
printf($patt, $ord, $day, $pos, $date->format('l, d M Y'));

// using vprintf() with an array
$arr  = [$ord, $day, $pos, $date->format('l, d M Y')];
vprintf($patt, $arr);

