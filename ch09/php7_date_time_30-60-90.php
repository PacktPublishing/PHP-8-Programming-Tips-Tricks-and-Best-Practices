<?php
// /repo/ch09/php7_date_time_30-60-90.php

// init vars
$days  = [30, 60, 90];
$fmt   = 'Y-m-d';
$aging = [];

// first cut: disaster
$dti = new DateTime('now');
$aging[0] = $dti;
foreach ($days as $span) {
    $interval = new DateInterval('P' . $span . 'D');
    $item = $dti->add($interval);
    $aging[$span] = clone $item;
}
echo "Day\tDate\n";
foreach ($aging as $key => $obj)
    echo "$key\t" . $obj->format($fmt) . "\n";

// second cut: much better!
$dti = new DateTimeImmutable('now');
$aging[0] = $dti;
foreach ($days as $span) {
    $interval = new DateInterval('P' . $span . 'D');
    $item = $dti->add($interval);
    // this works in PHP 7.3 and above:
    // $aging[$span] = DateTime::createFromImmutable($item);
    $aging[$span] = new DateTime($item->format($fmt));
}
echo "Day\tDate\n";
foreach ($aging as $key => $obj)
    echo "$key\t" . $obj->format($fmt) . "\n";
