<?php
// /repo/ch02/php7_variadic_vacuum.php
require_once __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Php7\Http\{Response,TestData};
$allowed = ['redirect' => 'redirect',
			'html'     => 'html',
			'json'     => 'json',
			'pdf'      => 'pdf'];
if ($_GET) {
	$type = $_GET['type'] ?? 'json';
	$type = $allowed[$type] ?? 'json';
	$body = TestData::$type();
	Response::$type($body);
	exit;
}
?>
<hr>
<form action="/ch02/php7_variadic_vacuum.php" method="get">
	<select  name="type">
	<?php foreach ($allowed as $key => $type) : ?>
	<option value="<?= $key ?>"><?= $type ?></option>
	<?php endforeach; ?>
	</select>
	<input type="submit" />
</form>
