<?php
// /repo/ch12/php8_fibers_blocked.php

// record start time and get PDO and callbacks
$start = microtime(TRUE);
$callbacks = include __DIR__ . '/php8_fibers_include.php';
foreach ($callbacks as $key => $exec) {
    $info = match ($key) {
        'read_url' => WAR_AND_PEACE,
        'db_query' => 'IN',
        'access_log' => __FILE__,
        default => ''
    };
    $result = $exec($info);
    echo "Executing $key: \t" . strlen($result) . "\n";
}
echo "Elapsed Time:" . (microtime(TRUE) - $start) . "\n";
