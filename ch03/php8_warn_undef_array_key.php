<?php
// /repo/ch03/php8_warn_undef_array_key.php

$key  = 'ABCDEF';
$vals = ['A' => 111, 'B' => 222, 'C' => 333];
echo $vals[$key[6]];

// output:
// Warning: Uninitialized string offset 6 in /repo/ch03/php8_warn_undef_array_key.php on line 6
// Warning: Undefined array key "" in /repo/ch03/php8_warn_undef_array_key.php on line 6
