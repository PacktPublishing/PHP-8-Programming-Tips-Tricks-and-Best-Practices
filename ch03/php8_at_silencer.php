<?php
// /repo/ch03/php8_at_silencer.php

function bad() {
    trigger_error(__FUNCTION__, E_USER_ERROR);
}

function worse() {
    return include __DIR__ .
        '/includes/causes_parse_error.php';
}

echo @bad();
echo "\n";
echo @worse();
echo "\nLast Line\n";
