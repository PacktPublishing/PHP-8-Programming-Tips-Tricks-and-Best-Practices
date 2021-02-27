<?php
// /repo/ch05/php8_serialization_wakeup_timing.php
class A
{
    public $dt = NULL;
    public $time = [];
    public $name = __CLASS__;
    public function __construct()
    {
        $this->dt = new DateTime();
    }
    public function __sleep()
    {
        $this->time[] = __METHOD__;
    }
    public function __wakeup()
    {
        $this->time[] = __METHOD__;
    }
}
class B extends A
{
    public $name = __CLASS__;
}
class C implements Serializable
{
    public $a = NULL;
    public $b = NULL;
    public function __construct()
    {
        $this->a = new A();
        $this->b = new B();
    }
    public function serialize()
    {
        return serialize($this);
    }
    public function unserialize($str)
    {
        return unserialize($str);
    }
}
$c = new C();
$str = serialize($c);
echo $str . "\n";
var_dump($c);
$d = $c->unserialize($str);
var_dump($d);
