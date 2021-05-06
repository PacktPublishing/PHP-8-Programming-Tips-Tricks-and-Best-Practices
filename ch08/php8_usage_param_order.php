<?php
// /repo/ch08/php8_usage_param_order.php

// this signature is a bad practice:
// function math(float $a, string $op = '+', float $b)

// we replace it with this:
function math(float $a, float $b, string $op = '+')
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

echo math(22, 7, '+');
echo math(22, 7, '-');
echo math(22, 7, '*');
echo math(22, 7, '/');
