<?php
declare(strict_types=1);
// /repo/ch01/php8_property_type.php
class Test
{
	public int $id = 0;
	public int $token = 0;
	public string $name = '';
}
$test = new Test();
$test->id = 'ABC';
// causes Fatal Error
