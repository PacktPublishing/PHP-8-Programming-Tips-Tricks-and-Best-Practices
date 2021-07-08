<?php
// /repo/ch07/php7_reflection_type_tostring.php

function get_name(string $first, string $last) : string {
    return sprintf('%s %s', $first, $last);
};

$reflect = new ReflectionFunction('get_name');
$type    = $reflect->getReturnType();
var_dump($type);
