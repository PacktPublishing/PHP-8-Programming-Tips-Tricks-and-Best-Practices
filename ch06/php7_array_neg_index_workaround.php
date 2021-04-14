<?php
// /repo/ch06/php7_array_neg_index_workaround.php

// initialize an array
$start = -3;
$b[$start] = 'CCC';
$b[++$start] = 'BBB';
$b[++$start] = 'AAA';
var_dump($b);

