<?php
// /repo/ch06/php8_num_str_is_numeric.php
$age = '77  ';
echo (is_numeric($age))
     ? "Age must be a number\n"
     : "Age is $age\n";
