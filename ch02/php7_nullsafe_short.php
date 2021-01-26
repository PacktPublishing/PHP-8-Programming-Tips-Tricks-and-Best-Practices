<?php
// /repo/ch02/php7_nullsafe_short.php
// to test functionality, comment out this line:
$config  = include __DIR__ . '/includes/nullsafe_config.php';
// and uncomment this line:
// $config = NULL;
$allowed = ['csv' => 'csv','json' => 'json','txt' => 'txt'];
$format  = $_GET['format'] ?? 'txt';
$ext     = $allowed[$format] ?? 'txt';
$fn      = __DIR__ . '/includes/nullsafe_data.' . $ext;
if (file_exists($fn)) {
	if (is_object($config)) {
		if (method_exists($config, 'display')) {
			if (method_exists($config, $ext)) {
				$config->display($config->$ext($fn));
			}
		}
	}
} else {
	echo "Data file not found in that format\n";
}
