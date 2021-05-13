<?php
// /repo/ch08/php7_back_trace.php

class Math
{
    public function add(...$args)
    {
        if (count($args) <= 1)
            throw new InvalidArgumentException('Missing arguments');
        $sum = array_sum($args);
        return 'The sum of ' . implode(' + ', $args) . " = $sum\n";
    }
}

try {
    $a = 2;
    $math = new Math();
    echo $math->add($a);
} catch (Throwable $t) {
    $trace = $t->getTrace();
    $trace['args'][0] = 4;
    var_dump($t->getTrace());
}
