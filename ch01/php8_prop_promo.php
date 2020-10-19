<?php
declare(strict_types=1);
// /repo/ch01/php8_prop_promo.php
class Test
{
	public function __construct(
		public int $id,
		public int $token = 0,
		public string $name = '')
	{ }
	
}
$test = new Test(999);
echo '<pre>';
var_dump($test);
echo '</pre>';
