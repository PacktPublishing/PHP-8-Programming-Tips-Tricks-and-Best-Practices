<?php
// ch03/php7_warn_array_unset.php

$alpha = 'ABCDEF';
// can't unset an offset in a non-array variable
unset($alpha[2]);
var_dump($alpha);
