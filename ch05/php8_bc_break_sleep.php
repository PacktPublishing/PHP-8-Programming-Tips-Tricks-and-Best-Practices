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
