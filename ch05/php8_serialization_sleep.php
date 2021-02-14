<?php
// /repo/ch05/php8_serialization_sleep.php
class Test  {
    public $name = 'Doug';
    protected $key = 12345;
    protected $password = '$2y$10$ux07vQNSA0ctbzZcZNAlxOa8hi6kchJrJZzqWcxpw/XQUjSNqacx.';
    public function __sleep()
    {
        return ['name','key'];
    }
}
$test = new Test();
$str = serialize($test);
echo $str . "\n";
