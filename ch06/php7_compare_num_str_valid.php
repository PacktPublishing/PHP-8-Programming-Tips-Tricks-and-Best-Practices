<?php
// /repo/ch06/php7_compare_num_str_valid.php

// comparing a numeric value against a string using "E" notation
$expo   = '4.2E+1';
$result = ($expo == 42) ? 'is' : 'is not';
echo "The value '$expo' $result the same as 42\n";

// comparing a numeric value against a numeric string with leading space
$lead   = '  42';
$result = ($expo == 42) ? 'is' : 'is not';
echo "The value '$lead' $result the same as 42\n";

// comparing a numeric value against a numeric string with trailing space
$trail  = '42  ';
$result = ($expo == 42) ? 'is' : 'is not';
echo "The value '$trail' $result the same as 42\n";
