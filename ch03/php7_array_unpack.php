<?php
// ch03/php7_array_unpack.php

function add($a, $b) { return $a + $b; }

// here's the data:
$vals = [ [18,48], [72,99], [11,37] ];

// we can unpack the array using "...":
foreach ($vals as $pair) {
    echo 'The sum of ' . implode(' + ', $pair) . ' is ';
    echo add(...$pair);
    echo "\n";
}
