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

// output:
// Warning: Declaration of Php7\Sql\Select::where(...$args) should be compatible with
// Php7\Sql\Where::where($a, $b = '', $c = '', $d = '') in /repo/src/Php7/Sql/Select.php on line 5
/*
SELECT id,event_key,event_name,event_date FROM events WHERE event_date >= '2021-01-01' AND event_date <= '2021-04-01' LIMIT 10
  ID |            Key |                               Title |                 Date
---- | -------------- | ----------------------------------- | --------------------
 153 | CON-PRO-WQ-145 |    Conservation Promotion Symposium |  2021-02-15 00:00:00
 155 | TRE-PRO-DF-540 |              Tree Promotion Meeting |  2021-02-28 00:00:00
 157 | SOL-LOV-KV-312 |          Solar Energy Lovers Summit |  2021-03-22 00:00:00
 158 | TRE-BEN-UC-744 |                 Tree Benefit Summit |  2021-03-19 00:00:00
 160 | HOR-IND-QM-995 |      Horticulture Industry Showcase |  2021-02-27 00:00:00
 166 | WIN-BEN-AE-715 |          Wind Power Benefit Meeting |  2021-03-12 00:00:00
 178 | HOR-PRO-QT-891 |      Horticulture Promotion Seminar |  2021-03-06 00:00:00
 182 | DOG-BEN-YQ-576 |                  Dog Benefit Summit |  2021-03-16 00:00:00
 188 | CAT-PRO-BM-255 |                  Cat Promotion Show |  2021-02-25 00:00:00
 211 | DOG-BEN-GZ-755 |              Dog Benefit Conference |  2021-03-28 00:00:00

 */
