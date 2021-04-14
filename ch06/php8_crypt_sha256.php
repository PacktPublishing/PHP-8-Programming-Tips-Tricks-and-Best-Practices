<?php
// /repo/ch06/php8_crypt_sha256.php

$password = 'password';
$salt     = str_repeat('+x=', CRYPT_SALT_LENGTH + 1);
$rounds   = 1;
$default  = crypt($password, $salt);
$sha256   = crypt($password, '$5$rounds=' . $rounds . '$' . $salt . '$');
echo "Default : $default\n";
echo "SHA-256 : $sha256\n";
