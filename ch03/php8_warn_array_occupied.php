<?php
// /repo/ch03/php8_warn_array_occupied.php

// Cannot add element to the array as the next element is already occupied
$a[PHP_INT_MAX] = 'This is the end!';
// goes off the end of the array!
$a[] = 'Off the deep end';
var_dump($a);

// output:
// Fatal error: Uncaught Error: Cannot add element to the array as the next element is already occupied in /repo/ch03/php8_warn_array_occupied.php on line 7
