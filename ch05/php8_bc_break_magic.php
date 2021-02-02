<?php
// /repo/ch05/php8_oop_bc_break_magic.php

class NoTypes
{
    public function __call($name, $args)
    {
        return "Attempt made to call '$name' "
             . "with these arguments: '"
             . implode(',', $args) . "'\n";
    }
}
$no = new NoTypes();
echo $no->doesNotExist('A','B','C');

class WithTypes
{
    public function __invoke(array $args) : string
    {
        return "Arguments: '"
             . implode(',', $args) . "'\n";
    }
}
$with = new WithTypes();
echo $with(['A','B','C']);

class WrongTypes
{
    public function __isset($var) : string
    {
        return (isset($this->var)) ? 'Y' : '';
    }
}
$wrong = new WrongTypes();
echo (isset($wrong->nothing)) ? 'Set' : 'Not Set';
echo "\n";

