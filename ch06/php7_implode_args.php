<?php
// /repo/ch06/php7_implode_args.php

$arr  = ['Person', 'Woman', 'Man', 'Camera', 'TV'];
echo __LINE__ . ':' . implode(' ', $arr) . "\n";
echo __LINE__ . ':' . implode($arr, ' ') . "\n";
