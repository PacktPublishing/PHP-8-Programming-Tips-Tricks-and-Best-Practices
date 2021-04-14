<?php
// /repo/ch06/php8_num_str_handling.php
$test = [
    0 => '111',
    1 => '   111',
    2 => '111   ',
    3 => '111xyz'
];
$patt = "%d : %3d : '%-s'\n";
foreach ($test as $key => $val) {
    $num = 111 + $val;
    printf($patt, $key, $num, $val);
}
