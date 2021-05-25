<?php
// /repo/ch09/php7_date_time.php

$fmt = 'l, d M Y';
$dti = new DateTimeImmutable('last day of next month');
echo get_class($dti) . ':' . $dti->format($fmt) . "\n";

// convert to DateTime and add 90 days
$dtt = DateTime::createFromImmutable($dti);
$dtt->add(new DateInterval('P90D'));
echo get_class($dtt) . ':' . $dtt->format($fmt) . "\n";

// convert back to DateTimeImmutable
$dtx = DateTimeImmutable::createFromMutable($dtt);
echo get_class($dtx) . ':' . $dtx->format($fmt) . "\n";

