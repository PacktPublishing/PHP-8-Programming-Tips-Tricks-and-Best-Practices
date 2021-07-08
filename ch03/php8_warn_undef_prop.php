<?php
// /repo/ch03/php8_warn_undef_prop.php

class Test
{
    public static $stat = 'STATIC';
    public $exists = 'NORMAL';
}

$obj = new Test();

echo $obj->exists;
echo "\n";
echo $obj->does_not_exist;
echo "\n";

try {
    echo Test::$stat;
    echo "\n";
    echo Test::$does_not_exist;
} catch (Error $e) {
    echo __LINE__ . ':' . $e;
}
echo "\n";

// output:
// Warning: Undefined property: Test::$does_not_exist in /repo/ch03/php8_warn_undef_prop.php on line 14
