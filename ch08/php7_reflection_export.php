<?php
// /repo/ch08/php7_reflection_export.php

class Test
{
    const ROLE = 'Caveman';
    private $name = 'Fred';
    public static $status = 'A';
    public function getTitle() : string
    {
        return self::ROLE . ' ' . $this->name;
    }
    public static function setStatus(string $status)
    {
        self::$status = $status;
    }
}

$obj = new Test();
$ref = new ReflectionObject($obj);
$test[0]['label']   = 'Using __toString()';
$test[0]['reflect'] = $ref->__toString();
$test[1]['label']   = 'Using export()';
// NOTE: export() is removed in PHP 8
$test[1]['reflect'] = ReflectionObject::export($obj, TRUE);
include __DIR__ . '/includes/reflection.html';
