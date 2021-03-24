<?php
// /repo/ch06/php7_compare_num_spaces.php

// comparing a numeric value against a numeric string with leading space
$valid   = '42';
$result = ($valid == 42) ? 'is' : 'is not';
echo "The value '$valid' $result the same as 42\n";

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
