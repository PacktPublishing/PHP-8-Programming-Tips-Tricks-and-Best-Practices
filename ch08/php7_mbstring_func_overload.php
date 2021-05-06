<?php
// /repo/ch08/php7_mbstring_func_overload.php
// NOTE: to test this example, enable function overloading as follows:
// # echo "mbstring.func_overload=7" >> /etc/php.ini

$str  = 'วันนี้สบายดีไหม';
$len1 = strlen($str);
$len2 = mb_strlen($str);
echo "Length of '$str' using 'strlen()' is $len1\n";
echo "Length of '$str' using 'mb_strlen()' is $len2\n";
