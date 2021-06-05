<?php
// /repo/ch10/php8_jit_mandelbrot.php
// Mandelbrot implementation taken from:
// https://gist.github.com/dstogov/12323ad13d3240aee8f1

/*
To test JIT, you need to enable OpCache:
# sed -i 's/;zend_extension=opcache/zend_extension=opcache/g' /etc/php.ini
# sed -i 's/;opcache.enable=0/opcache.enable=1/g' /etc/php.ini
# sed -i 's/;opcache.enable_cli=0/opcache.enable_cli=1/g' /etc/php.ini
# /etc/init.d/php-fpm restart
*/

// To enable JIT:
// CLI: php php8_jit_mandelbrot.php 32M
// HTTP: http://php php8_jit_mandelbrot.php?jit=32M

// To disable JIT:
// CLI: php php8_jit_mandelbrot.php 0
// HTTP: http://php php8_jit_mandelbrot.php?jit=0

define('BAILOUT',   16);
define('MAX_LOOPS', 1000000);
define('EDGE',      40.0);

$cli = empty($_SERVER['REQUEST_URI']);
$mem = $_GET['jit'] ?? $argv[1] ?? 0;
$mem = strip_tags($mem);
ini_set('opcache.jit_buffer_size', $mem);

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
if (!$cli) {
    $out = '<pre>' . $out . '</pre>';
}
echo $out;
$d2 = microtime(1);
$diff = $d2 - $d1;
printf("\nPHP Elapsed %0.3f\n", $diff);
