<?php
// /repo/ch10/php8_sort_stable.php
require __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Services\SortTest;
$arr = SortTest::build();
usort($arr, function ($a, $b) { return $a->name <=> $b->name; });
// In PHP 7 the ID values are all over the place
// In PHP 8 the IDs respect the original order assigned
echo "\nSorted by Name\n";
echo "NOTE: sort() wipes out the original keys\n";
echo SortTest::show($arr);
