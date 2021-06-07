<?php
// /repo/ch10/php8_jit_mandelbrot.php
// Mandelbrot implementation taken from:
// https://gist.github.com/dstogov/12323ad13d3240aee8f1

/*
Make sure OpCache is enabled (should be done already!).
Look for these settings in the /etc/php.ini file:
zend_extension=opcache
opcache.enable=1
opcache.enable_cli=1
opcache.jit=off
opcache.jit_buffer_size=64M
*/

/*
CLI usage :
php php8_jit_reset.php on|off|tracing|function|NNNN [debug=NNN]\n"
php php8_jit_mandelbrot.php [on|off|tracing|function|NNNN]
*
HTTP usage: /php8_jit_mandelbrot.php?mode=on|off|tracing|function|NNNN
*/

define('BAILOUT',   16);
define('MAX_LOOPS', 10000);
define('EDGE',      40.0);

// grab tracer settings (if any)
$allowed = ['off', 'on', 'tracing', 'function'];
$mode = $_GET['mode'] ?? $argv[1] ?? 'off';
$http = !empty($_SERVER['REQUEST_URI']);

// validate $mode
if (!in_array($mode, $allowed)) $mode = (int) $mode;

// ini_set() doesn't work from the command line
if ($mode !== 0 && $http) ini_set('opcache.jit', $mode);

function iterate($x,$y)
{
    $cr = $y-0.5;
    $ci = $x;
    $zr = 0.0;
    $zi = 0.0;
    $i = 0;
    while (true) {
        $i++;
        $temp = $zr * $zi;
        $zr2 = $zr * $zr;
        $zi2 = $zi * $zi;
        $zr = $zr2 - $zi2 + $cr;
        $zi = $temp + $temp + $ci;
        if ($zi2 + $zr2 > BAILOUT)
            return $i;
        if ($i > MAX_LOOPS)
            return 0;
    }

}

// produce the ASCII image
$d1  = microtime(1);
$f   = EDGE - 1;
$out = '';
for ($y = -$f; $y < $f; $y++) {
    for ($x = -$f; $x < $f; $x++) {
        if (iterate($x/EDGE,$y/EDGE) == 0)
            $out .= '*';
        else
            $out .= ' ';
    }
    $out .= "\n";
}

// wrap in HTML if running from web server
if (!empty($_SERVER['REQUEST_URI'])) {
    $out = '<pre>' . $out . '</pre>';
}
echo $out;
$d2 = microtime(1);
$diff = $d2 - $d1;
printf("\nPHP Elapsed %0.3f\n", $diff);
