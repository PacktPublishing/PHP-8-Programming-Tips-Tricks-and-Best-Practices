<?php
// /repo/ch03/php8_at_silencer_err_rep.php

function handler(int $errno , string $errstr) {
    // works in PHP 7 but not PHP 8:
    $report = error_reporting();
    echo 'Error Reporting : ' . $report . "\n";
    echo 'Error Number    : ' . $errno . "\n";
    echo 'Error String    : ' . $errstr . "\n";
    if (error_reporting() == 0) {
        echo "IF statement works!\n";
    }
}
function bad() {
    trigger_error('We Be Bad', E_USER_ERROR);
}
set_error_handler('handler');
echo @bad();
