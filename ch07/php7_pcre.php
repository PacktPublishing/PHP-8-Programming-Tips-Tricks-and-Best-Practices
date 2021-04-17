<?php
// /repo/ch07/php7_pcre.php

$pregTest = function ($pattern, $string) {
    $result  = preg_match($pattern, $string);
    $lastErr = preg_last_error();
    if ($lastErr == PREG_NO_ERROR) {
        $msg = 'RESULT: ';
        $msg .= ($result) ? 'MATCH' : 'NO MATCH';
    } else {
        $msg = 'ERROR : ';
        if (function_exists('preg_last_error_msg'))
            $msg .= preg_last_error_msg();
        else
            $msg .= $lastErr;
    }
    return "$msg\n";
};

$pattern = '/\8+/';
$string  = 'test test test test 8';
echo $pregTest($pattern, $string);

$pattern = '/(?:\D+|<\d+>)*[!?]/';
$string  = 'test test test test ';
echo $pregTest($pattern, $string);
