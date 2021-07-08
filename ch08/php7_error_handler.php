<?php
// /repo/ch08/php7_error_handler.php

function handler($errno, $errstr, $errfile, $errline, $errcontext = NULL)
{
    echo "Number : $errno\n";
    echo "String : $errstr\n";
    echo "File   : $errfile\n";
    echo "Line   : $errline\n";
    if (!empty($errcontext))
        echo "Context: \n" . var_export($errcontext, TRUE);
    exit;
}

function level1($a, $b, $c)
{
    trigger_error("This is an error", E_USER_ERROR);
}

set_error_handler('handler');
echo level1(TRUE, 222, 'C');

// $errcontext is ignored in PHP 8
