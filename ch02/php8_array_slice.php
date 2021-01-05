<?php
// /repo/ch02/php8_array_slice.php
ini_set('memory_limit', '1G');
// build a large array
// NOTE: hrtime() "high resolution time" is much better for benchmarks
//       however it's only available from PHP 7.3+
//       this container is using PHP 7.1 and 8.0
$start = microtime(TRUE);
$arr   = [];
$alpha = range('A', 'Z');
$beta  = $alpha;
$loops = 10000;     // size of outer array
$iters = 500;       // total iterations
$drip  = 10;        // output every $drip times
$cols  = 4;
for ($x = 0; $x < $loops; $x++)
    foreach ($alpha as $left)
        foreach ($beta as $right)
            $arr[] = $left . $right . rand(111,999);
$max = count($arr);
$tmp = $cols;
$pattern = '%10d : %s  | ';
echo "\nTotal Elements : " . number_format($max) . "\n";
echo "Iterations     : " . number_format($iters) . "\n";
echo "Output Every   : " . $drip . " iterations\n";
for ($x = 0; $x < $iters; $x++ ) {
    $offset = rand(999999, $max);
    $slice  = array_slice($arr, $offset, 4);
    if ($x % $drip === 0) {
        printf($pattern, $offset, $arr[$offset]);
        if ($tmp-- === 0) {
            echo "\n";
            $tmp = $cols;
        }
    }
}
$time = (microtime(TRUE) - $start);
echo "\nElapsed Time: $time seconds\n";
