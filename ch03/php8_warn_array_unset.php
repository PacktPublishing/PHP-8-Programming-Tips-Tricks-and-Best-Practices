<?php
// ch03/php8_warn_array_unset.php

$alpha = 'ABCDEF';
// can't unset an offset in a non-array variable
unset($alpha[2]);
var_dump($alpha);
