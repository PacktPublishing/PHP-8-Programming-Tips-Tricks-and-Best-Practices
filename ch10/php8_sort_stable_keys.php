<?php
// /repo/ch010/php8_sort_stable_keys.php

// function to produce random 3 letter combinations
$randVal = function () {
    $alpha = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return $alpha[rand(0,25)] . $alpha[rand(0,25)] . $alpha[rand(0,25)];
};

// load the sample data into the iterator
$start = microtime(TRUE);
$max   = 20;
$iter  = new ArrayIterator;
for ($x = 256; $x < $max + 256; $x += 2) {
    // create random 3 letter combination
    $key = sprintf('%04X', $x);
    $iter->offsetSet($key, $randVal());
    // every other value is a duplicate
    $key = sprintf('%04X', $x + 1);
    $iter->offsetSet($key, 'AAA');
}

echo "Before\n";
foreach ($iter as $key => $value) echo "$key\t$value\n";
$iter->asort();
echo "\nAfter\n";
foreach ($iter as $key => $value) echo "$key\t$value\n";
echo "\nElapsed Time: " . (microtime(TRUE) - $start) . "\n";
