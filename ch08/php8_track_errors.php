<?php
// /repo/ch08/php8_track_errors.php

// ignored in PHP 8
// ini_set('track_errors', 1);
try {
    @strpos();
    // PHP 7.4 will not throw an Error
    echo error_get_last()['message'];
    echo "\nOK\n";
} catch (Error $e) {
    // PHP 8 will throw and Error
    echo $e->getMessage();
    echo "\nERROR\n";
}
