<?php
// /repo/ch07/php8_intl_date_fmt.php

$dt = new DateTime('tomorrow');
$pt = [IntlDateFormatter::RELATIVE_FULL,
    IntlDateFormatter::RELATIVE_LONG,
    IntlDateFormatter::RELATIVE_MEDIUM,
    IntlDateFormatter::RELATIVE_SHORT
];
foreach ($pt as $fmt)
    echo IntlDateFormatter::formatObject($dt, $fmt) . "\n";

