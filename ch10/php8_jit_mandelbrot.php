<?php
// /repo/ch10/php8_jit_mandelbrot.php

// To enable JIT:
// CLI: php php8_jit_mandelbrot.php [--enable-jit]
// Web: /php8_jit_mandelbrot.php?enable=1

$enable = 0;
$enable += (!empty($_GET['enable']) && $_GET['enable'] > 0);
$enable += (!empty($argv[1]) && $argv[1] === '--enable-jit');
$size = ($enable) ? 64 : 0;
ini_set('opcache.jit_buffer_size', $size);

include __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Php8\Jit\Mandelbrot;

$man = new Mandelbrot();
$man::$cols = 80;
$man::$bailout = 16;
$man::$iterations = 100000;
if (empty($_SERVER['argv'])) {
    echo '<pre>';
    echo $man;
    echo '</pre>';
} else {
    echo $man;
}
