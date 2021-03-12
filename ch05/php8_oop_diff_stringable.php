<?php
// /repo/ch05/php8_oop_diff_stringable.php

class Test
{
    public function __toString() { return __CLASS__; }
}
$test = new Test();
echo "$test\n";

// test for Stringable interface
if ($test instanceof Stringable)
    echo "This class implements the Stringable interface\n";

// reflection
$reflect = new ReflectionObject($test);
var_dump($reflect->getInterfaceNames());
