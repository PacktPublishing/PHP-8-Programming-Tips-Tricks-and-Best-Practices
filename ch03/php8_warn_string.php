<?php
// ch03/php8_warn_string.php

// Cannot assign an empty string to a string offset
try {
    $alpha = 'ABCDEF';
    // can't unset an offset in non-array variable
    $alpha[2] = NULL;
    var_dump($alpha);
} catch (Error $e) {
    echo 'ERROR: ' . $e->getMessage() . "\n";
}

