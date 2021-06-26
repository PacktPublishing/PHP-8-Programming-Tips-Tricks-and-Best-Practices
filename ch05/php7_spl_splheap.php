<?php
// /repo/ch05/php7_spl_splheap.php
// works in PHP 7 but not PHP 8

// data drawn from https://www.forbes.com/real-time-billionaires/
define('SRC_FILE', __DIR__ . '/../sample_data/billionaires.txt');

require_once __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();

use Services\BillionaireTracker;
$tracker = new BillionaireTracker();
$list = $tracker->extract(SRC_FILE);

// create the heap + define its "compare()" method
$heap = new class () extends SplHeap {
    public function compare(array $arr1, array $arr2) : int {
        $cmp1 = array_values($arr2)[0];
        $cmp2 = array_values($arr1)[0];
        return $cmp1 <=> $cmp2;
    }
};

// insert list of billionaires into heap
foreach ($list as $item)
    $heap->insert($item);

// iterate through each node and display the result
$patt = "%20s\t%32s\n";
$line = str_repeat('-', 56) . "\n";
echo $tracker->view($heap, $patt, $line);
