<?php
// /repo/ch010/php7_spl_fixed_arr_size.php

define('MAX_SIZE', 1000000);
define('PATTERN', "%14s : %8.8f : %12s\n");
function testArr($list, $label)
{
    $alpha = new InfiniteIterator(new ArrayIterator(range('A','Z')));
    $start_mem = memory_get_usage();
    $start_time = microtime(TRUE);
    for ($x = 0; $x < MAX_SIZE; $x++) {
        $letter = $alpha->current();
        $alpha->next();
        $list[$x] = str_repeat($letter, 64);
    }
    $mem_diff = memory_get_usage() - $start_mem;
    return [$label,
            microtime(TRUE) - $start_time,
            number_format($mem_diff)];
}
printf("%14s : %10s : %12s\n", '', 'Time', 'Memory');

// build a conventional array of 100,000
$result = testArr([], 'Array');
vprintf(PATTERN, $result);

// build an ArrayObject of 100,000
$result = testArr(new ArrayObject(), 'ArrayObject');
vprintf(PATTERN, $result);

// build an SplFixedArray of 100,000
$result = testArr(new SplFixedArray(MAX_SIZE), 'SplFixedArray');
vprintf(PATTERN, $result);
