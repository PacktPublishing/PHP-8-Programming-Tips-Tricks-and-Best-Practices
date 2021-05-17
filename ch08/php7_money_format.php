<?php
// /repo/ch08/php7_money_format.php

// set monetary locale to USA
$amt = 1234567.89;
setlocale(LC_MONETARY, 'en_US');
echo "Natl: " . money_format('%n', $amt) . "\n";
echo "Intl: " . money_format('%i', $amt) . "\n";

// set monetary locale to Germany
setlocale(LC_MONETARY, 'de_DE');
echo "Natl: " . money_format('%n', $amt) . "\n";
echo "Intl: " . money_format('%i', $amt) . "\n";

