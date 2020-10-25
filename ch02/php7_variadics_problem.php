<?php
// /repo/ch02/php7_variadics_problem.php
require_once __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Php7\Sql\Select;
$start = "'2021-01-01'";
$end   = "'2021-04-01'";
$select = new Select();
$select->from('events')
	   ->cols(['id', 'event_key', 'event_name', 'event_date'])
	   ->limit(10)
	   ->where('event_date', '>=', $start, 'AND', 'event_date', '<=', $end);
$sql = $select->render();
$dsn = 'mysql:host=localhost;dbname=php8_tips';
$pdo = new PDO($dsn, 'php8', 'password');
echo '<pre>';
echo $sql . "\n";
$pat1 = "%4s | %14s | %35s | %20s\n";
$pat2 = "%4d | %14s | %35s | %20s\n";
printf($pat1, 'ID', 'Key', 'Title', 'Date');
printf($pat1, '----', str_repeat('-', 14), str_repeat('-', 35), str_repeat('-', 20));
$stmt = $pdo->query($sql);
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	vprintf($pat2, $row);
}
echo '</pre>';
 
