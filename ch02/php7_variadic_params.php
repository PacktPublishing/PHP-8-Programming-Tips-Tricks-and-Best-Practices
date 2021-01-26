<?php
// /repo/ch02/php7_variadic_params.php
function multiVardump(...$args)
{
	$output = '';
	foreach ($args as $var) {
		$output .= var_export($var, TRUE);
		$output .= "\n";
	}
	return $output;
}

$a = new ArrayIterator(range('A','F'));
$b = function (string $val) { return str_rot13($val); };
$c = [1,2,3];
$d = 'TEST';

echo multiVardump($a, $b, $c);
echo multiVardump($d);
