<?php
// /repo/ch03/php8_warn_array.php

$pattern = '%12s : %s' . PHP_EOL;

// Cannot add element to the array as the next element is already occupied
try {
    $a[PHP_INT_MAX] = 'This is the end!';
    // goes off the end of the array!
    $a[] = 'Off the deep end';
    var_dump($a);
} catch (Error $e) {
    printf($pattern, get_class($e), $e->getMessage());
}

// Error
try {
    $alpha = 'ABCDEF';
    // can't unset an offset in a non-array variable
    unset($alpha[2]);
    var_dump($alpha);
} catch (Error $e) {
    printf($pattern, get_class($e), $e->getMessage());
}

// TypeError
try {
    $alpha = 'ABCDEF';
    // only array and Traversable can be unpacked
    echo array_pop($alpha) . "\n";
    // same applies to any array function that has to "unpack" the array: e.g. array_slice()
    echo array_slice($alpha, 3);
    echo "\n";
} catch (Error $e) {
    printf($pattern, get_class($e), $e->getMessage());
}

// Illegal offset type
try {
    $obj = new stdClass();
    // can't use an object as an array key
    $b = ['A' => 1, 'B' => 2, $obj => 3];
    var_dump($b);
} catch (Error $e) {
    printf($pattern, get_class($e), $e->getMessage());
}

// Illegal offset type in isset or empty
try {
    $obj = new stdClass();
    $obj->c = 'C';
    // can't use an object as an array key
    $b = ['A' => 1, 'B' => 2, 'C' => 3];
    echo (empty($b[$obj])) ? 'NOT FOUND' : 'FOUND';
    echo "\n";
} catch (Error $e) {
    printf($pattern, get_class($e), $e->getMessage());
}


// Illegal offset type in unset
try {
    $obj = new stdClass();
    $obj->c = 'C';
    // can't use an object as an array key
    $b = ['A' => 1, 'B' => 2, 'C' => 3];
    unset($b[$obj]);
    var_dump($b);
} catch (Error $e) {
    printf($pattern, get_class($e), $e->getMessage());
}

// output:
/*
Warning: Cannot add element to the array as the next element is already occupied in /repo/ch03/php7_warn_array.php on line 10
array(1) {
  [9223372036854775807] =>
  string(16) "This is the end!"
}
       Error : Cannot unset string offsets
Warning: array_pop() expects parameter 1 to be array, string given in /repo/ch03/php7_warn_array.php on line 30
Warning: array_slice() expects parameter 1 to be array, string given in /repo/ch03/php7_warn_array.php on line 32
Warning: Illegal offset type in /repo/ch03/php7_warn_array.php on line 42
array(2) {
  'A' =>
  int(1)
  'B' =>
  int(2)
}
Warning: Illegal offset type in isset or empty in /repo/ch03/php7_warn_array.php on line 54
NOT FOUND
Warning: Illegal offset type in unset in /repo/ch03/php7_warn_array.php on line 67
array(3) {
  'A' =>
  int(1)
  'B' =>
  int(2)
  'C' =>
  int(3)
}
 */
