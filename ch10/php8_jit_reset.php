<?php
// /repo/ch10/php8_jit_reset.php

/*
Make sure OpCache is enabled (should be done already!):
# sed -i 's/;zend_extension=opcache/zend_extension=opcache/g' /etc/php.ini
# sed -i 's/;opcache.enable=0/opcache.enable=1/g' /etc/php.ini
# sed -i 's/;opcache.enable_cli=0/opcache.enable_cli=1/g' /etc/php.ini
*/

/**
 * Locates substring $search in $arr
 * @param string $search : substring to locate
 * @param array $arr : array to search
 * @returns FALSE | int corresponding to array key where item found
 */
function findInArray(string $search, array $arr)
{
    foreach($arr as $pos => $line) {
        if (str_contains($line, $search)) {
            return $pos;
        }
    }
    return FALSE;
}

$usage = "\nUSAGE:\n"
       . "php php8_jit_reset.php on|off|tracing|function|NNNN [debug=NNN]\n"
       . "  first argument: sets JIT to \"tracing\" mode to one of on|off|tracing|function|NNNN \n"
       . "  debug    : sets JIT debug mode to NNN\n"
       . "\nNOTE: if plan to run this demo from a browser, also do the following from the command line:\n"
       . "/etc/init.d/php-fpm restart\n";

// grab CLI args, etc.
$params  = implode(' ', $argv);
$php_ini = file('/etc/php.ini');
$mode    = $argv[1] ?? 'on';

// disable xdebug extension, otherwise JIT is disabled
$pos = findInArray('xdebug.so', $php_ini);
if (is_int($pos) && !empty($php_ini[$pos])) {
    $line = &$php_ini[$pos];
    // if mode === 'off' re-enable xdebug
    if ($mode === 'off') {
        if ($line[0] === ';')
            $line = substr($line, 1);
    } else {
        // otherwise disable xdebug
        $line = ';' . $line;
    }
}

// validate $mode
$allowed = ['off', 'on', 'tracing', 'function'];
if (!in_array($mode, $allowed)) $mode = (int) $mode;
if ($mode === 0) $mode='off';

// set debug (if requested)
$debug   = 0;
if (str_contains($params, 'debug')) {
    preg_match('/\bdebug=(\d+)\b/', $params, $matches);
    $debug = (int) ($matches[1] ?? 0);
}

// JIT mode
$pos = findInArray('opcache.jit=', $php_ini);
if (is_int($pos) && !empty($php_ini[$pos])) {
    $php_ini[$pos] = 'opcache.jit=' . $mode . "\n";
} else {
    $php_ini[] = 'opcache.jit=' . $mode . "\n";
}

// JIT debug mode
if ($debug) {
    $pos = findInArray('opcache.jit_debug=', $php_ini);
    if (is_int($pos) && !empty($php_ini[$pos])) {
        $php_ini[$pos] = 'opcache.jit_debug=' . $debug . "\n";
    } else {
        $php_ini[] = 'opcache.jit_debug=' . $debug . "\n";
    }
}

// Set buffer to 0 if mode is "off"
$buff = ($mode === 'off') ? 0 : '64M';
$pos = findInArray('opcache.jit_buffer_size=', $php_ini);
if (is_int($pos) && !empty($php_ini[$pos])) {
    $php_ini[$pos] = 'opcache.jit_buffer_size=' . "$buff\n";
} else {
    $php_ini[] = 'opcache.jit_buffer_size=' . "$buff\n";
}

// write changes and display
file_put_contents('/etc/php.ini', implode('', $php_ini));
readfile('/etc/php.ini');
echo $usage;
