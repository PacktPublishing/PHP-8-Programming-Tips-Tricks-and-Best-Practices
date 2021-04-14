<?php
// /repo/ch07/php8_mb_string_empty_needle.php

// The quick brown fox jumped over the fence. (Thai language)
$text   = 'สุนัขจิ้งจอกสีน้ำตาลกระโดดข้ามรั้วอย่างรวดเร็ว';
$needle = NULL;
$funcs  = ['mb_strpos', 'mb_strrpos', 'mb_stripos', 'mb_strripos',
           'mb_strstr', 'mb_stristr', 'mb_strrchr', 'mb_strrichr'];
// run through functions and display results
$patt   = "Testing: %12s : %s\n";
foreach ($funcs as $str)
    printf($patt, $str, $str($text, $needle));
