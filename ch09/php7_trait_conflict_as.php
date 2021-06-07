<?php
// /repo/ch09/php7_trait_conflict_as.php

trait Test1 {
    public function test()
    {
        return '111111';
    }
}
trait Test2
{
    public function test()
    {
        return '222222';
    }
}
$main = new class () {
    use Test1, Test2 { test as otherTest; }
    public function test() { return 'TEST'; }
};
echo $main->test() . "\n";
echo $main->otherTest() . "\n";
