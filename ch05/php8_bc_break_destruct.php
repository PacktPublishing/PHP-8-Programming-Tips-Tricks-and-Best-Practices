<?php
// /repo/ch05/php8_bc_break_destruct.php
include __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Php7\Connector\ {ConnectPdo,ConnectMysqli};
$db  = 'test';
$usr = 'fake';
$pwd = 'xyz';
$dsn = 'mysql:host=localhost;dbname=' . $db;
$sql = 'SELECT event_name, event_date FROM events';
$ptn = "%2d : %s : %s\n";
try {
    $conn = new ConnectPdo($dsn, $usr, $pwd);
    var_dump($conn->query($sql));
} catch (Throwable $t) {
    printf($ptn, __LINE__, get_class($t), $t->getMessage());
}

$conn = new ConnectMysqli($db, $usr, $pwd);
var_dump($conn->query($sql));

// output:
/*
16 : PDOException : SQLSTATE[28000] [1045] Access denied for user 'fake'@'localhost' (using password: YES)
Warning: mysqli_connect(): (HY000/1045): Access denied for user 'fake'@'localhost' (using password: YES) in /repo/src/Php7/Connector/ConnectMysqli.php on line 8
Unable to Connect
 */
