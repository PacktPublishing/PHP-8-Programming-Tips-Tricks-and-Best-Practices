<?php
// /repo/ch06/php8_num_str_needle_type_hint.php
declare(strict_types=1);
function search(string $needle, string $haystack)
{
    $found = (strpos($haystack, $needle))
               ? 'contains'
               : 'DOES NOT contain';
    return "This string $found LF characters\n";
}

$haystack = "We're looking\nFor linefeeds\nIn this string\n";
$needle   = 10;         // ASCII code for LF
echo search($needle, $haystack);
