<?php
// /repo/ch05/php8_oop_diff_array_key_exists.php

$obj = new class () {
    public $var = 'OK.';
};
$default = 'DEFAULT';
echo (isset($obj->var)) ? $obj->var : $default;
echo (property_exists($obj,'var')) ? $obj->var : $default;
echo (array_key_exists('var',$obj)) ? $obj->var : $default;
echo "\n";
