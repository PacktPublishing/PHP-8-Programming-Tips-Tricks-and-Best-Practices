<?php
// ch03/php7_warn_array_occupied.php

// Cannot add element to the array as the next element is already occupied
$a[PHP_INT_MAX] = 'This is the end!';
// goes off the end of the array!
$a[] = 'Off the deep end';
var_dump($a);
