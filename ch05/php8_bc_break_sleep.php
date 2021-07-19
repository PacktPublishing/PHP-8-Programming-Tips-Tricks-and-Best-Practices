<?php
// /repo/ch05/php8_bc_break_sleep.php
class Test
{
    public $name = 'Doug';
    public function __sleep() {
        return ['name', 'missing'];
    }
}

echo "Test instance before serialization:\n";
$test = new Test();
var_dump($test);

echo "Test instance after serialization:\n";
$stored = serialize($test);
$restored = unserialize($stored);
var_dump($restored);

// output:
/*
Test instance before serialization:
/repo/ch05/php8_bc_break_sleep.php:13:
class Test#1 (1) {
  public $name =>
  string(4) "Doug"
}
Test instance after serialization:
Warning: serialize(): "missing" returned as member variable from __sleep() but does not exist in /repo/ch05/php8_bc_break_sleep.php on line 16
class Test#2 (1) {
  public $name =>
  string(4) "Doug"
}

 */
