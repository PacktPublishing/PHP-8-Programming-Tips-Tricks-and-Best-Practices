<?php
// /repo/ch08/php7_real.php

$a = 22/7;
switch (TRUE) {
    // "is_real()" is removed in PHP 8
    case is_real($a) :
        $msg = "$a is a real number\n";
        break;
    case is_int($a) :
        $msg = "$a is a real number\n";
        break;
    case is_object($a) :
        $msg = '$a is an object' . "\n";
        break;
    case is_array($a) :
        $msg = '$a is an array' . "\n";
        break;
    default :
        $msg = '$a is an unknown' . "\n";
}
echo $msg;
