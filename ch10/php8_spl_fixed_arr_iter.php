<?php
// /repo/ch010/php8_spl_fixed_arr_iter.php
$arr   = ['Person', 'Woman', 'Man', 'Camera', 'TV'];
$obj   = SplFixedArray::fromArray($arr);
$fixed = $obj->getIterator();
while ($fixed->valid()) {
    echo $fixed->current() . '. ';
    $fixed->next();
}
echo "\n";
