<?php
// /repo/ch03/php8_warn_un_init_offset.php

$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
echo strpos($str, 'Z', strpos($str, 'A'));
echo "\n";
echo strpos($str, 'Z', 27);
echo "\n";
