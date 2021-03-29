<?php
// /repo/ch06/php8_curly_brace_usage.php

$class = new class () {
    public $h = 'Hello';
    public $w = 'world';
    public $s = ' ';
    public $b = ['h','s','w'];
    public function getHello()
    {
        for ($x = 0; $x < 3; $x++)
            echo $this->{$this->b[$x]};
    }
};
// output: "Hello World"

$func = function ($max, $min = 1) { return rand($min,$max); };
echo "{$class->getHello()}, "
     . "today is: {$func(2022,2001)}-{$func(12)}-{$func(28)}\n";

