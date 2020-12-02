<?php
// ch03/php8_string_access_using_array_syntax.php

$url = 'https://unlikelysource.com/';
if ($url[-1] == '/') {
    $url = substr($url, 0, -1);
}
echo $url;
