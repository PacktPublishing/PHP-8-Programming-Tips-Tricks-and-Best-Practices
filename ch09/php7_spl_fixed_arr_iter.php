<?php
// /repo/ch09/php7_spl_fixed_arr_iter.php

$arr   = ['Person', 'Woman', 'Man', 'Camera', 'TV'];
$fixed = SplFixedArray::fromArray($arr);
while ($fixed->valid()) {
    echo $fixed->current() . '. ';
    $fixed->next();
}
echo "\n";
