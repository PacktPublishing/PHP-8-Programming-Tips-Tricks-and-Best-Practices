<?php
declare(strict_types=1);
// /repo/ch01/php8_prop_danger.php
class Test
{
	protected int $id = 0;
	protected int $token = 0;
	protected string $name = '';
	public function __construct(int $id, int $token, string $name)
	{
		$this->id = $id;
		$this->token = md5((string) $token);
		$this->name = $name;
	}
	
}
echo '<pre>';
$test = new Test(111, 123456, 'Fred');
var_dump($test);
echo '</pre>';
