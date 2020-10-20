<?php
// /repo/ch02/php7_variadic_vacuum.php
require_once __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Php7\Http\Response;

if ($_POST) {
	$allowed = ['redirect','html','json','pdf'];
	$type = $_POST['type'] ?? 'json';
	$body = $_POST['body'] ?? 'TEST';
	$body = strip_tags($body);
	if (!in_array($type, $allowed, TRUE)) {
		$type = 'json';
	}
	$method = $type . 'Response';
	ob_start();
	Response::$method($body);
	$output = ob_end_clean();
} else {
}
