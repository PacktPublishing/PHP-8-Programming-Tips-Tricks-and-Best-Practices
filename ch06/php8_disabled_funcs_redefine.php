<?php
// /repo/ch06/php8_disabled_funcs_redefine.php
// You need to add the following to your php.ini file:
// disable_functions=system

// this works in PHP 8 but not PHP 7
function system(string $cmd, string $path = NULL)
{
    $output = '';
    $path = $path ?? __DIR__;
    if ($cmd === 'ls -l') {
        $iter = new RecursiveDirectoryIterator($path);
        foreach ($iter as $fn => $obj)
            $output .= $fn . "\n";
    }
    return $output;
}

echo system('ls -l');

