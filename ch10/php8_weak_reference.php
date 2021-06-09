<?php
// /repo/ch010/php8_weak_reference.php

$obj1 = new class () { public $name = 'Fred'; };
$obj2 = $obj1;

// if we unset $obj1, it still lives on as a Zombie inside of $obj2
var_dump($obj1);
unset($obj1);
var_dump($obj2);

// If we create a weak reference to $obj1 and then destroy it, it doesn't go away because of $obj2:

$obj1 = new class () { public $name = 'Fred'; };
$weakref = WeakReference::create($obj1);
$obj2 = $weakref;
var_dump($obj1, $obj2, $weakref);

var_dump($weakref->get());  // object exists
unset($obj1);
var_dump($weakref->get());  // object exists
