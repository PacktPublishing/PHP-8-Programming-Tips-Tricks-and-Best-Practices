<?php
// /repo/ch05/php8_bc_break_magic_wrong.php

class WrongType
{
    public function __isset($var) : string
    {
        return (isset($this->$var)) ? 'Y' : '';
    }
}
$wrong = new WrongType();
echo (isset($wrong->nothing)) ? 'Set' : 'Not Set';
echo "\n";

