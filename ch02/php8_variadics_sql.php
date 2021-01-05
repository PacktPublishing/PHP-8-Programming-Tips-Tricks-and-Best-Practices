<?php
// /repo/ch02/php8_variadics_sql.php
require_once __DIR__ . '/includes/php8_sql_lib.php';
$start = '2021-01-01';
$end   = '2021-04-01';
$select = new stdClass();
from($select, 'events');
cols($select, ['id', 'event_key', 'event_name', 'event_date']);
limit($select, 10);
where($select, 'event_date', '>=', "'$start'", 'AND', 'event_date', '<', "'$end'");
$sql = render($select);
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
 
