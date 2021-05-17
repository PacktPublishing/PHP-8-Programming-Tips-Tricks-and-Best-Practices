<?php
// /repo/ch08/php7_usage_param_order.php

function math(float $a, string $op = '+', float $b)
{
    switch ($op) {
        case '-' :
            $out = "$a - $b = " . ($a - $b);
            break;
        case '*' :
            $out = "$a * $b = " . ($a * $b);
            break;
        case '/' :
            $out = "$a / $b = " . ($a / $b);
            break;
        case '+' :
        default :
            $out = "$a + $b = " . ($a + $b);
    }
    return $out . "\n";
}

echo math(22, '+', 7);
echo math(22, '-', 7);
echo math(22, '*', 7);
echo math(22, '/', 7);
