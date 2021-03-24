<?php
// /repo/app_a/php7_parse_str_bad.php

// init vars
$redirect= 'https://unlikelysource.com/';
$pattern = "ID : %4d | Name : %8s | Status : %s\n";
$query   = $_SERVER['QUERY_STRING'] ?? '';

// bad practice:
// relies upon PHP to produce magic variables from query string
parse_str($query);
printf($pattern, $id, $name, $status);

// simulated redirect:
echo "<br />Redirecting  to $redirect ... \n";
