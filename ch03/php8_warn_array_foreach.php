<?php
// /repo/ch03/php8_warn_array_foreach.php

$alpha = 'ABCDEF';
// use a non-array in foreach()
foreach ($alpha as $letter) echo $letter;
echo "Continues ... \n";

// output:
// Warning: foreach() argument must be of type array|object, string given in /repo/ch03/php8_warn_array_foreach.php on line 6
