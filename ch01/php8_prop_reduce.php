<?php
// /repo/ch01/php8_prop_reduce.php
declare(strict_types=1);
class Test {
	public int $id = 0;
	public int $token = 0;
	public string  $name = '';
}

// assign values
$test = new Test();
$test->id = 111;
$test->token = 999999;
$test->name = 'Fred';

// display results
$pattern = '<tr><th>%s</th><td>%s</td></tr>';
echo '<table width="50%" border=1>';
printf($pattern, 'ID', $test->id);
printf($pattern, 'Token', $test->token);
printf($pattern, 'Name', $test->name);
echo '</table>';
