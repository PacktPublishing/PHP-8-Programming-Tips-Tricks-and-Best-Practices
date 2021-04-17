<?php
// /repo/ch07/php7_ext_is_resource.php

$url = 'https://unlikelysource.com/';
$ch  = curl_init($url);
if (is_resource($ch)) {
    echo "Connection Established\n";
} else {
    throw new Exception('Unable to establish connection');
}
