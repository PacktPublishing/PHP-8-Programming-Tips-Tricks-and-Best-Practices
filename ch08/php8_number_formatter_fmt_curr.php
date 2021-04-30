<?php
// /repo/ch08/php8_number_formatter_fmt_curr.php

// set monetary locale to USA
$amt = 1234567.89;
$fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );
echo "Natl: " . $fmt->formatCurrency($amt, 'USD') . "\n";
$fmt->setSymbol(NumberFormatter::CURRENCY_SYMBOL, 'USD ');
echo "Intl: " . $fmt->format($amt) . "\n";

// set monetary locale to Germany
$fmt = new NumberFormatter( 'de_DE', NumberFormatter::CURRENCY );
echo "Natl: " . $fmt->formatCurrency($amt, 'EUR') . "\n";
$fmt->setSymbol(NumberFormatter::CURRENCY_SYMBOL, 'EUR');
echo "Intl: " . $fmt->format($amt) . "\n";

