<?php
// /repo/ch07/php7_mb_string_strpos.php

// encoding
define('ENCODING', 'UTF-8');
// The quick brown fox jumped over the fence. (Thai language)
$text    = 'สุนัขจิ้งจอกสีน้ำตาลกระโดดข้ามรั้วอย่างรวดเร็ว';
// convert to encoding defined by ENCODING
$encoded = mb_convert_encoding($text, ENCODING);
// fence (Thai language)
$needle  = 'รั้ว';
// search for last occurrence of "fence"
echo 'String Length: ' . mb_strlen($encoded, ENCODING) . "\n";
echo 'Substring Pos: ' . mb_strrpos($encoded, $needle, ENCODING) . "\n";
