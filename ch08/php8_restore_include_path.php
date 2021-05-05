<?php
// /repo/ch08/php7_restore_include_path.php

echo get_include_path();
echo "\n";
set_include_path(get_include_path() . PATH_SEPARATOR . '/usr/bin');
echo get_include_path();
echo "\n";
// this works in PHP 4 through PHP 8
ini_restore('include_path');
echo get_include_path();
echo "\n";
