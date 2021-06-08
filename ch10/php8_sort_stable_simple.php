<?php
// /repo/ch010/php8_sort_stable_simple.php
require __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Php8\Sort\Access;

// load the sample data into $access
$access = [];
$data = new SplFileObject(__DIR__ . '/../sample_data/access.csv');
while ($row = $data->fgetcsv())
    if (!empty($row) && count($row) === 2)
        $access[] = new Access($row[0], $row[1]);

// The YYYY-mm-dd 11:11:11 dates are duplicated
// expected order following sort for these dates:
// Fred, Betty, Barney, Wilma
// Also, the YYYY-mm-dd 03:33:33 dates expected order:
// Betty, Barney

echo "Before\n";
foreach ($access as $entry)
    echo $entry->time . "\t" . $entry->name . "\n";

usort($access, function($a, $b) { return $a->time <=> $b->time; });
echo "\nAfter\n";
foreach ($access as $entry)
    echo $entry->time . "\t" . $entry->name . "\n";

