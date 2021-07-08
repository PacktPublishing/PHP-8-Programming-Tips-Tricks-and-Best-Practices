<?php
// /repo/ch12/php8_fibers_unblocked.php

// record start time and get PDO and callbacks
$start = microtime(TRUE);
$callbacks = include __DIR__ . '/php8_fibers_include.php';

// create Fiber instances
$fibers = [];
foreach ($callbacks as $key => $exec) {
    $info = match ($key) {
        'read_url' => WAR_AND_PEACE,
        'db_query' => 'IN',
        'access_log' => __FILE__,
        default => ''
    };
    $fibers[$key] = new Fiber($exec);
    $fibers[$key]->start($info);
}

// let them run and report when they're done
$count  = count($fibers);
$names  = array_keys($fibers);
while ($count) {
    $count = 0;
    foreach ($names as $name) {
        if ($fibers[$name]->isTerminated()) {
            $result = $fibers[$name]->getReturn();
            echo "Executing $name: \t" . strlen($result) . "\n";
            unset($names[$name]);
        } else {
            $count++;
        }
    }
}
echo "Elapsed Time:" . (microtime(TRUE) - $start) . "\n";
