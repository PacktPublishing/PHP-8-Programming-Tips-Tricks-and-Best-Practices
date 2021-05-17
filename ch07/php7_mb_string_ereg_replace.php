<?php
// /repo/ch07/php7_mb_string_strpos.php

// encoding
define('ENCODING', 'UTF-8');

// 2 quick brown foxes jumped over the fence. (Thai language)
$text = 'สุนัขจิ้งจอกสีน้ำตาล 2 ตัวกระโดดข้ามรั้ว';

// convert to encoding defined by ENCODING
$str  = mb_convert_encoding($text, ENCODING);

// set encoding for mb_ereg*
mb_regex_encoding(ENCODING);

// 50 is the ASCII value for "2"
$mod1 = mb_ereg_replace(50, '3', $str);
echo "Original: $str\n";
echo "Modified: $mod1\n";
