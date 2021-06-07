<?php
// /repo/ch09/php8_trailing_comma.php

$full = function ($fn, $ln, $mid = '',) {
    $mi = ($mid)
        ? strtoupper($mid[0]) . '. '
        : '';
    return $fn . ' ' . $mi . $ln;
};

echo $full('Fred', 'Flintstone', 'John');
