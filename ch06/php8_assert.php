<?php
// /repo/ch06/php8_assert.php
// you need to first enable assertions:
// # echo 'zend.assertions=1'>>/etc/php.ini

// set assert() to throw an exception
ini_set('assert.exception', 1);

// init vars
$pi = 22/7;
echo 'Value of 22/7: ' . $pi . "\n";
echo 'Value of M_PI: ' . M_PI . "\n";

// attempt assertion as an expression
try {
    $line    = __LINE__ + 2;
    $message = "Assertion as expression failed on line ${line}\n";
    $result  = assert($pi === M_PI, new AssertionError($message));
    echo ($result) ? "Everything's OK\n" : "We have a problem\n";
} catch (Throwable $t) {
    echo $t->getMessage() . "\n";
}

// attempt assertion as a string
try {
    $line    = __LINE__ + 2;
    $message = "Assertion as a string failed on line ${line}\n";
    $result  = assert('$pi === M_PI', new AssertionError($message));
    echo ($result) ? "Everything's OK\n" : "We have a problem\n";
} catch (Throwable $t) {
    echo $t->getMessage() . "\n";
}

