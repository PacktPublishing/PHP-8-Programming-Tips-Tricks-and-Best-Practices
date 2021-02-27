<?php
// /repo/ch05/php8_serialization.php
class Test  {
    public $name = 'Doug';
    private $key = 12345;
    protected $status = ['A','B','C'];
}
$test = new Test();
$str = serialize($test);
echo $str . "\n";
$obj = unserialize($str);
var_dump($test, $obj);
