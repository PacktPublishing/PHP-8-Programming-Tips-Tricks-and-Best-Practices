<?php
// /repo/ch02/php8_ops_variadic.php
class Upper {
    public function test(
		int $id,
		string $name,
		mixed $here)
	{
		echo "ID: $id\n"
			 . "Name: $name\n"
			 . "Here: $here\n";
	}
}
class Lower extends Upper {
    public function test(...$everything)
    {
		var_dump($everything);
	}
}
$lower = new Lower();
echo '<pre>';
echo $lower->test(999, 'Fred', 'YES');
echo '</pre>';
