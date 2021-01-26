<?php
declare(strict_types=1);
// /repo/ch01/php8_mixed_type.php
class High
{
	const LOG_FILE = __DIR__ . '/../data/test.log';
	protected static function logVar(object $var)
	{
		$item = date('Y-m-d') . ':'
			  . var_export($var, TRUE);
		return error_log($item, 3, self::LOG_FILE);
	}
}
class Low extends High
{
	public static function logVar(mixed $var)
	{
		$item = date('Y-m-d') . ':'
			  . var_export($var, TRUE);
		return error_log($item, 3, self::LOG_FILE);
	}
}

if (file_exists(High::LOG_FILE)) unlink(High::LOG_FILE);
$test = [
	'array' => range('A', 'F'),
	'func' => function () { return __CLASS__; },
	'anon' => new class () { public function __invoke() { return __CLASS__; } },
];
foreach ($test as $item) Low::logVar($item);
echo '<pre>';
readfile(High::LOG_FILE);
echo '</pre>';
