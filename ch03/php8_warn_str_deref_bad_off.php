<?php
// /repo/ch03/php8_warn_str_deref_bad_off.php

$obj = new stdClass();
$obj->a = 1;
$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
echo $str[$obj];
