<?php
// /repo/ch03/php8_undef_const.php
// this works OK:
echo PHP_OS . "\n";
// this no longer works in PHP 8:
echo UNDEFINED_CONSTANT . "\n";
// program DOES NOT continue OK
echo "Program Continues ... \n";
