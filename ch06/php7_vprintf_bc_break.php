<?php
// /repo/ch06/php8_vprintf_bc_break.php

$patt = "\t%s. %s. %s. %s. %s.";
$arr  = ['Person', 'Woman', 'Man', 'Camera', 'TV'];
$args = [
    'Array' => $arr,
    'Int'   => 999,
    'Bool'  => TRUE,
    'Obj'   => new ArrayObject($arr)
];
foreach ($args as $key => $value) {
    try {
        echo $key . ': ' . vsprintf($patt, $value);
    } catch (Throwable $t) {
        echo $key . ': ' . get_class($t) . ':' . $t->getMessage();
    }
    echo "\n";
}

