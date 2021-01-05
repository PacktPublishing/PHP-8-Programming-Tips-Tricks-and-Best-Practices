<?php
// /repo/ch03/php7_undef_const.php
// this works OK:
echo PHP_OS . "\n";
// generates a WARNING in PHP 7 and below, but allows the program to continue
echo UNDEFINED_CONSTANT . "\n";
// program continues OK
echo "Program Continues ... \n";

