<?php
// /repo/ch05/php8_bc_break_magic_to_string.php
class Test
{
    public $fname = 'Fred';
    public $lname = 'Flintstone';
    public function __toString() : string
    {
        return $this->fname . ' ' . $this->lname;
    }
}
$test = new Test;
$reflect = new ReflectionObject($test);
echo $reflect;

