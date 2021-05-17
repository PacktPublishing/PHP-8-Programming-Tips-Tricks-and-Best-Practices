<?php
// /repo/ch07/php7_reflection_signature.php


class Test extends ReflectionClass
{
    public $vars = [];
    public function __construct()
    {
        parent::__construct(__CLASS__);
    }
    public function newInstance($args)
    {
        $this->vars = func_get_args();
        return $this;
    }
    public function getVars()
    {
        return implode(',', $this->vars);
    }
}
$test = new Test();
$fred = $test->newInstance('Fred','Flintstone');
echo $fred->getVars();
