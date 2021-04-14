<?php
// /repo/ch06/php8_password_hash.php

$salt = 'xxxxxxxxxxxxxxxxxxxxxx';
$password = 'password';
$hash = password_hash($password, PASSWORD_DEFAULT, ['salt' => $salt]);
echo $hash . "\n";
var_dump(password_get_info($hash));
