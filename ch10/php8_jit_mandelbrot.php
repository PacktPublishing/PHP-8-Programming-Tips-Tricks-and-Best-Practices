<?php
// /repo/ch10/php8_jit_mandelbrot.php

/*
Make sure OpCache is enabled (should be done already!).
Look for these settings in the /etc/php.ini file:
zend_extension=opcache
opcache.enable=1
opcache.enable_cli=1
*/

// init defaults
define('BAILOUT',   16);
define('MAX_LOOPS', 10000);
define('EDGE',      40.0);

// grab start time
$d1  = microtime(1);

// allows CLI arg or $_GET param "time" to show only the elapsed time
// USAGE: php php8_jit_mandelbrot.php [-n]
$time_only = (bool) ($argv[1] ?? $_GET['time'] ?? FALSE);

// Mandelbrot implementation based up:
// https://gist.github.com/dstogov/12323ad13d3240aee8f1
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
$f   = EDGE - 1;
$out = '';
for ($y = -$f; $y < $f; $y++) {
    for ($x = -$f; $x < $f; $x++) {
        $out .= (iterate($x/EDGE,$y/EDGE) == 0)
              ? '*'
              : ' ';
    }
    $out .= "\n";
}

// wrap in HTML if running from web server
if (!empty($_SERVER['REQUEST_URI'])) {
    $out = '<pre>' . $out . '</pre>';
}
if (!$time_only) echo $out;
$d2 = microtime(1);
$diff = $d2 - $d1;
printf("\nPHP Elapsed %0.3f\n", $diff);
