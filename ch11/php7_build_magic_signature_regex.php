<?php
// /repo/ch011/php7_build_magic_signature_regex.php
// builds regex for allowed magic method signatures

// init break scanner using config file
require __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Php8\Migration\BreakScan;
$config  = include __DIR__ . '/php8_bc_break_scanner_config.php';
$config = $config[BreakScan::KEY_MAGIC];

foreach ($config as $key => $def) {
    // build the regex
    $typ = $def['types'] ?? [];
    $sub = $def['signature'];
    $ret = array_pop($typ); // return value
    $ptn = '/' . $key . '\s*' . '\(';
    if (!empty($typ)) {
        foreach ($typ as $arg)
            $ptn .= '(' . $arg . '\s)?\$.+?';
    }
    $ptn .= '\)';
    if (strpos($sub, ':'))
        $ptn .= '\s*:\s*' . $ret;
    $ptn .= '/';
    echo $ptn . "\n";
}

