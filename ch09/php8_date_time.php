<?php
// /repo/ch09/php8_date_time.php

$fmt = 'l, d M Y';
$dti = new DateTimeImmutable('last day of next month');
echo $dti::class . ':' . $dti->format($fmt) . "\n";

// convert to DateTime and add 90 days
$dtt = DateTime::createFromInterface($dti);
$dtt->add(new DateInterval('P90D'));
echo $dtt::class . ':' . $dtt->format($fmt) . "\n";

// convert back to DateTimeImmutable
$dtx = DateTimeImmutable::createFromInterface($dtt);
echo $dtx::class . ':' . $dtx->format($fmt) . "\n";

