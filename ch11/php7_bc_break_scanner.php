<?php
// /repo/ch010/php8_weak_map_problem.php

/**
 * Usage:
 * php php7_bc_break_scanner.php PATH [LEVEL] [CSV]
 * PATH  : starting directory to recursive scan (PHP files only)
 * LEVEL : 0 = pass/fail only; 1 = all messages
 * CSV   : name of CSV file to write results
 */

// DEMO_PATH points to phpMyAdmin 4.6.6 (2017-01-23)
// See: https://www.phpmyadmin.net/files/

define('DEMO_PATH', __DIR__ . '/../src/phpMyAdmin-4.6.6-all-languages');
require __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Migration\OopBreakScan;

$path    = $_GET['path'] ?? $argv[1] ?? DEMO_PATH;
$show    = $_GET['show'] ?? $argv[2] ?? 0;  // 1 = show pass/fail; 2 = show all messages
$show    = (int) $show;
$csv     = $_GET['csv']  ?? $argv[3] ?? '';

$config  = include __DIR__ . '/php8_bc_break_scanner_config.php';
$scanner = new OopBreakScan($config);

// get list of files
$iter = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($path));

// only accept *.php
$filter = new class ($iter) extends FilterIterator {
    public function accept()
    {
        $obj = $this->current();
        return ($obj->getExtension() === 'php');
    }
};

// if CSV, open up CSV file to write
if ($csv) {
    $csv_file = new SplFileObject($csv, 'w');
}
// scan files
$total = 0;
foreach ($filter as $name => $obj) {
    $found    = 0;  // number of possible BC breaks
    $messages = []; // messages about possible breaks
    if (dirname($name) !== $dir) {
        $dir = dirname($name);
        echo str_repeat('*', 40) . "\n";
        echo "Processing Directory: \n$name\n;";
        echo str_repeat('*', 40) . "\n";
    }
    $fn = basename($name);
    echo "Processing: $fn\n";
    $contents = file_get_contents($name);
    $found += $scanner->scanRemovedFunctions($contents, $messages);
    $found += $scanner->scanSpacesInNamespace($contents, $messages);
    $found += $scanner->scanMagicSignatures($contents, $messages);
    $found += $scanner->scanFromConfig($contents, $messages);
    // display results
    echo "Number of possible BC breaks: $found\n";
    switch ($show) {
        case 1 :
            echo implode("\n", $messages);
            break;
        case 0 :
        default :
            echo ($found)
                ? OopBreakScan::WARN_BC_BREAKS
                : OopBreakScan::NO_BC_BREAKS;
    }
    // write to CSV file
    if ($csv)
        foreach ($messages as $text)
            $csv_file->fputcsv([$dir, $fn, $text]);
    $total += $found;
    echo "\n";
}
echo str_repeat('-', 40) . "\n";
echo "\nTotal number of possible BC breaks: $total\n";
