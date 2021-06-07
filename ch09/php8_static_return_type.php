<?php
// /repo/ch09/php8_static_return_type.php
require_once __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Php8\Sql\Select;
$start = "'2021-06-01'";
$end   = "'2021-12-31'";
$select = new Select();
echo $select->from('events')
           ->cols(['id', 'event_name', 'event_date'])
           ->limit(10)
           ->where('event_date', '>=', $start)
           ->where('AND', 'event_date', '<=', $end)
           ->render();
echo "\n";
