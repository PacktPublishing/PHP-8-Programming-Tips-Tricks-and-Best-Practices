<?php
// /repo/ch02/php8_starts_ends_with.php
$url = 'http://phptraining.net/logout';
$check_url_old = function ($url, $start, $end) {
    $msg = '';
    if (!str_starts_with($url, $start))
        $msg .= "URL does not start with $start\n";
    if (!str_ends_with($url, $end))
        $msg .= "URL does not end with $end\n";
    return $msg;
};
$msg = $check_url_old($url, 'https', 'login');
echo ($msg) ? $msg : "Proceeding with login\n";
