<?php
// /repo/ch05/php8_serialization_wakeup.php
class Gettysburg
{
    public $fn = __DIR__ . '/gettysburg.txt';
    public $obj = NULL;
    public function __construct()
    {
        $this->obj = new SplFileObject($this->fn, 'r');
    }
    public function getText()
    {
        $this->obj->rewind();
        return $this->obj->fpassthru();
    }
    public function __sleep()
    {
        return ['fn'];
    }
    public function __wakeup()
    {
        self::__construct();
    }
}
$old = new Gettysburg();
echo $old->getText();
$str = serialize($old);
$new = unserialize($str);
echo $new->getText();

