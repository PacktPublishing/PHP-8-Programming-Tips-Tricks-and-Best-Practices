<?php
// /repo/ch10/php8_sort_illegal.php
require __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Services\SortTest;
$arr = SortTest::build();

// works in PHP 7 but not PHP 8
uasort($arr, function ($a, $b) { return $a->name > $b->name; });
echo "\nSorted by Name\n";
echo "NOTE: sort() wipes out the original keys\n";
echo SortTest::show($arr);
