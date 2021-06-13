<?php
// /repo/ch010/php8_weak_map_problem.php

require __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Migration\OopBreakScan;

$scan = new OopBreakScan;
$messages = [];

// get list of files
// scan files
// display results
