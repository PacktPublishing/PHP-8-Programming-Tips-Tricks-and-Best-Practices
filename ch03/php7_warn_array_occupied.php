<?php
// ch03/php7_warn_array_occupied.php

// Cannot add element to the array as the next element is already occupied
$a[PHP_INT_MAX] = 'This is the end!';
// goes off the end of the array!
$a[] = 'Off the deep end';
var_dump($a);

// output:
/*
Warning: Cannot add element to the array as the next element is already occupied in /repo/ch03/php7_warn_array_occupied.php on line 7
array(1) {
  [9223372036854775807] =>
  string(16) "This is the end!"
}
 */
