<?php
// /repo/ch06/php7_curly_brace_usage.php

// this doesn't work in either 8:
$func = [
    1 => function () {
        $a = ['A' => 111, 'B' => 222, 'C' => 333];
        echo 'WORKS: ' . $a{'C'} . "\n";},
    2 => function () {
        eval('$a = {"A","B","C"};');
    },
    3 => function () {
        eval('$a = ["A","B"]; $a{} = "C";');
    }
];
foreach ($func as $example => $callback) {
    try {
        echo "\nTesting Example $example\n";
        $callback();
    } catch (Throwable $t) {
        echo $t->getMessage() . "\n";
    }
}
