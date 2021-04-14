<?php
// /repo/ch06/php8_args_resolve_null.php

class Test
{
    public function test0($radius, $pi = MY_PI)
    {
        return ($pi * $radius) ** 2;
    }
    public function test1($radius, $pi = NULL)
    {
        return ($pi * $radius) ** 2;
    }
    public function test2($radius, ?float $pi = MY_PI)
    {
        return ($pi * $radius) ** 2;
    }
    // this also works in php 8:
    // public function test1 (float $radius, float|null $pi = MY_PI)
}

$test = new Test();

echo "Default: undefined constant\n";
try { echo __LINE__ . ':' . $test->test0(9.99); }
catch(Error $e) { echo $e . "\n"; }

echo "Default: passed undefined var\n";
try { echo __LINE__ . ':' . $test->test0(9.99, $not); }
catch(Error $e) { echo $e . "\n"; }

echo "\nDefault: NULL\n";
try { echo __LINE__ . ':' . $test->test1(9.99); }
catch(Error $e) { echo $e . "\n"; }

echo "\nDefault: undefined constant with nullable type\n";
try { echo __LINE__ . ':' . $test->test2(9.99, NULL); }
catch(Error $e) { echo $e . "\n"; }
echo "\n";
