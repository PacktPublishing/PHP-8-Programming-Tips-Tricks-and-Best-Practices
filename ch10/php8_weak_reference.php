<?php
// /repo/ch010/php8_weak_reference.php

$obj1 = new class () { public $name = 'Fred'; };
$obj2 = $obj1;
$obj3 = new class () { public $name = 'Fred'; };
$obj4 = WeakReference::create($obj3);

// if we unset $obj1, it still lives on as a Zombie inside of $obj2
var_dump($obj2);
unset($obj1);
var_dump($obj2);

// WeakReference::get() returns the associated object
var_dump($obj4->get());
unset($obj3);
var_dump($obj4->get());
