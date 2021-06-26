<?php
// /repo/ch11/php8_xdebug.php
// for this to work, add the following settings to /etc/php.ini:
/*
zend_extension=/usr/lib/php/extensions/no-debug-non-zts-20201009/xdebug.so
xdebug.log=/repo/xdebug.log
xdebug.log_level=7
xdebug.mode=develop,profile
 */
// Also, make sure you restart PHP-FPM:
// /etc/init.d/php-fpm restart

echo "Executing Mandelbrot ... but disabled output ...\n";
ob_start();
include __DIR__ . '/../ch10/php8_jit_mandelbrot.php';
$contents = ob_get_contents();
ob_end_clean();
$lines = explode("\n", $contents);
$last = array_pop($lines);
echo "$last\n";
xdebug_info();


