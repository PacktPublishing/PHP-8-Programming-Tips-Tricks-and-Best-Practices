<?php
// /repo/ch08/php8_create_function.php
// sample entry in "access.log":
// 1.15.175.155 - - [17/Apr/2021:02:59:58 -0400] "GET / HTTP/1.0" 200 34680

$start = microtime(TRUE);
$normalize = function (&$line, $key) {
    $split = strpos($line, ' ');
    $ip = trim(substr($line, 0, $split));
    $remainder = substr($line, $split);
    $tmp = explode(".", $ip);
    if (count($tmp) === 4)
        $ip = vsprintf("%03d.%03d.%03d.%03d", $tmp);
    $line = $ip . $remainder;
};
$sort_by_ip = fn ($line1, $line2) => $line1 <=> $line2;
$orig   = __DIR__ . '/../sample_data/access.log';
$log    = file($orig);
$sorted = new SplFileObject(__DIR__ . '/access_sorted_by_ip.log', 'w');
array_walk($log, $normalize);
usort($log, $sort_by_ip);
foreach ($log as $line) $sorted->fwrite($line);
$time = microtime(TRUE) - $start;
echo "Time Diff: $time\n";


