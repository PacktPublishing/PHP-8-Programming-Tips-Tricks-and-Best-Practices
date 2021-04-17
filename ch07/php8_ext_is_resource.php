<?php
// /repo/ch07/php8_ext_is_resource.php

$url = 'https://unlikelysource.com/';
$ch  = curl_init($url);
if (!empty($ch)) {
    echo "Connection Established\n";
} else {
    throw new Exception('Unable to establish connection');
}
var_dump($ch);
