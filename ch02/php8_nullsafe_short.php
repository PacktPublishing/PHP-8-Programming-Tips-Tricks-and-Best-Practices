<?php
// /repo/ch02/php8_nullsafe_short.php

// to test functionality, comment out this line:
$config  = include __DIR__ . '/includes/nullsafe_config.php';
// and uncomment this line:
// $config = NULL;
$allowed = ['csv' => 'csv','json' => 'json','txt' => 'txt'];
$format  = $_GET['format'] ?? $argv[1] ?? 'txt';
$ext     = $allowed[$format] ?? 'txt';
$fn      = __DIR__ . '/includes/nullsafe_data.' . $ext;
if (file_exists($fn)) {
	$config?->display($config->$ext($fn));
} else {
	echo "Data file not found in that format\n";
}
