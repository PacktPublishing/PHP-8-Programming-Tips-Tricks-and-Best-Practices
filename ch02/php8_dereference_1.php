<?php
// /repo/ch02/php7_dereference_1.php
$alpha = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$num   = '0123456789';
$test  = [15, 7, 15, 34];
foreach ($test as $pos)
	echo "$alpha$num"[$pos];
