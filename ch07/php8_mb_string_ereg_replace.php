<?php
// /repo/ch07/php8_mb_string_strpos.php

// encoding
define('ENCODING', 'UTF-8');

// 2 quick brown foxes jumped over the fence. (Thai language)
$text = 'สุนัขจิ้งจอกสีน้ำตาล 2 ตัวกระโดดข้ามรั้ว';

// convert to encoding defined by ENCODING
$str  = mb_convert_encoding($text, ENCODING);

// using "mb_chr()"
mb_regex_encoding(ENCODING);
$mod1 = mb_ereg_replace(mb_chr(50), '3', $str);
echo "Original: $str\n";
echo "Modified: $mod1\n";
