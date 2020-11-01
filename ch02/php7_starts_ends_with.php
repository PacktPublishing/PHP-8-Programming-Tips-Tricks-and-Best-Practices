<?php
// /repo/ch02/php7_starts_ends_with.php
$url = 'http://phptraining.net/logout';
$check_url_old = function ($url, $start, $end) {
    $msg = '';
    if (substr($url, 0, strlen($start)) !== $start)
        $msg .= "URL does not start with $start\n";
    if (strpos(strrev($url), strrev($end)) !== 0)
        $msg .= "URL does not end with $end\n";
    return $msg;
};
$msg = $check_url_old($url, 'https', 'login');
echo ($msg) ? $msg : "Proceeding with login\n";
