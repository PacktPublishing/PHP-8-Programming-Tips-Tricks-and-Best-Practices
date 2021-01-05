<?php
// /repo/ch05/php8_construct_exit.php
class ConstExcept
{
    public function __construct()
    {
        throw new Exception(__METHOD__ . "\n");
    }
    public function __destruct()
    {
        echo __METHOD__ . "\n";
    }
}
class ExitsEarly
{
    public function __construct()
    {
        exit(__METHOD__ . "\n");
    }
    public function __destruct()
    {
        echo __METHOD__ . "\n";
    }
}
try {
    $obj = new ConstExcept();
} catch (Throwable $t) {
    echo get_class($t) . ':' . $t->getMessage();
}
$obj = new ExitsEarly();
