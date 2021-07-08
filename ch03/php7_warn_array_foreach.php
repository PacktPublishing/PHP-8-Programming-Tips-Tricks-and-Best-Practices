<?php
// /repo/ch03/php7_warn_array_foreach.php

$alpha = 'ABCDEF';
// use a non-array in foreach()
foreach ($alpha as $letter) echo $letter;
echo "Continues ... \n";

// output:
/*
Warning: Invalid argument supplied for foreach() in /repo/ch03/php7_warn_array_foreach.php on line 6
Continues ...
 */
