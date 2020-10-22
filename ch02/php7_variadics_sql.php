<?php
// /repo/ch02/php7_variadics_sql.php
require_once __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Php7\Sql\Select;
$start = "'2021-01-01'";
$end   = "'2021-04-01'";
$select = new Select();
$select->from('events')
       ->cols(['id', 'event_key', 'event_name', 'event_date'])
	   ->where('event_date', '>=', $start)
	   ->where('AND')
	   ->where('event_date', '<=', $end);
echo $select->render();
echo "\n";
 
