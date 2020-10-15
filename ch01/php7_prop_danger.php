<?php
declare(strict_types=1);
// /repo/ch01/php7_prop_danger.php
class Test
{
	protected $id = 0;
	protected $token = 0;
	protected $name = '';
	public function __construct(int $id, int $token, string $name)
	{
		$this->id = $id;
		$this->token = md5((string) $token);
		$this->name = $name;
	}
	
}
$test = new Test(111, 123456, 'Fred');
echo '<pre>';
var_dump($test);
echo '</pre>';
