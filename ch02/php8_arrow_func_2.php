<?php
// /repo/ch02/php8_arrow_func_2.php

// "traditional" anonymous function:
$today = new DateTime('now');
$format = 'Y-m-d H:i:s';
$old   = function ($today) use ($format) {
	return $today->format($format);
};

// arrow function:
$new = fn($today) => $today->format($format);

echo "Old: " . $old($today) . "\n";
echo "New: " . $new($today) . "\n";
