<?php
// /repo/ch03/php8_warn_array_unset.php

$alpha = 'ABCDEF';
// can't unset an offset in a non-array variable
unset($alpha[2]);
var_dump($alpha);

// output:
// Fatal error: Uncaught Error: Cannot unset string offsets in /repo/ch03/php8_warn_array_unset.php on line 6
