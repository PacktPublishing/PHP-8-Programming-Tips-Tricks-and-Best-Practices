<?php
// /repo/ch11/php7_bc_break_scanner.php
// WARNING: only use this in CLI mode on a production server!!!

/**
 * CLI Usage:
 * php php7_bc_break_scanner.php PATH [LEVEL] [CSV]
 * PATH  : starting directory to recursive scan (PHP files only)
 * SHOW  : 0 = show failed files only
 *         1 = show failed files and all messages
 *         2 = show all results
 * CSV   : name of CSV file to write results
 */

// DEMO_PATH points to phpMyAdmin 4.6.6 (2017-01-23)
// See: https://www.phpmyadmin.net/files/

// autoloading and usage
define('DEMO_PATH', __DIR__ . '/../sample_data/phpMyAdmin-4.6.6-all-languages');
require __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Php8\Migration\BreakScan;

// usage
$usage = <<<EOT
CLI Usage:
    php php7_bc_break_scanner.php PATH [SHOW] [CSV]
        PATH  : starting directory; produces a recursive list of PHP files
        SHOW  : 0 = show failed files only
                1 = show failed files and all messages
                2 = show all results
        CSV   : name of CSV file to store results
www usage:
    /php7_bc_break_scanner.php?path=/PATH/TO/FILES[&show=0|1|2][&csv=/PATH/TO/CSV]

EOT;

// grab params
$path    = $_GET['path'] ?? $argv[1] ?? NULL;
$show    = $_GET['show'] ?? $argv[2] ?? 0;  // 1 = show pass/fail; 2 = show all messages
$show    = (int) $show;
$csv     = $_GET['csv']  ?? $argv[3] ?? '';

// check for path
if (empty($path)) {
    if (!empty($_SERVER['REQUEST_URI'])) {
        echo '<pre>' . $usage . '</pre>';
    } else {
        echo $usage;
    }
    exit;
}


// init break scanner using config file
$config  = include __DIR__ . '/php8_bc_break_scanner_config.php';
$scanner = new BreakScan($config);

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
    $csv_file->fputcsv(['Directory','File','OK','Messages']);
}

// write to CSV func
$write = function ($dir, $fn, $found, $messages) use ($csv_file) {
    $ok = ($found === 0) ? 1 : 0;
    $csv_file->fputcsv([$dir, $fn, $ok, $messages]);
    return TRUE;
};
// scan files
$dir   = '';
$total = 0;
foreach ($filter as $name => $obj) {
    $found    = 0;  // number of possible BC breaks
    $scanner->clearMessages(); // resets messages
    if (dirname($name) !== $dir) {
        $dir = dirname($name);
        echo str_repeat('*', 40) . "\n";
        echo "Processing Directory: \n$name\n";
        echo str_repeat('*', 40) . "\n";
    }
    $fn = basename($name);
    $scanner->getFileContents($name);
    $found    = $scanner->runAllScans();
    $messages = implode("\n", $scanner->getMessages());
    // determine show level
    switch ($show) {
        case 2 :
            echo "Processing: $fn\n";
            echo "$messages\n";
            if ($csv) $write($dir, $fn, $found, $messages);
            break;
        case 1 :
            if ($found) {
                echo "Processing: $fn\n";
                echo BreakScan::WARN_BC_BREAKS . "\n";
                printf(BreakScan::TOTAL_BREAKS, $found);
                echo "$messages\n";
                if ($csv) $write($dir, $fn, $found, $messages);
            }
            break;
        case 0 :
        default :
            if ($found) {
                echo "Processing: $fn\n";
                echo BreakScan::WARN_BC_BREAKS . "\n";
                if ($csv) $write($dir, $fn, $found, $messages);
            }
    }
    $total += $found;
    echo "\n";
}
echo str_repeat('-', 40) . "\n";
echo "\nTotal number of possible BC breaks: $total\n";
