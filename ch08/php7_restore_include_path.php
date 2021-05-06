<?php
// /repo/ch08/php7_restore_include_path.php

echo get_include_path();
echo "\n";
set_include_path(get_include_path() . PATH_SEPARATOR . '/usr/bin');
echo get_include_path();
echo "\n";
// doesn't work in PHP 8
restore_include_path();
echo get_include_path();
echo "\n";
