<?php
// /repo/ch05/php8_bc_break_destruct.php
class Base
{
    public $conn = NULL;
    public function __destruct()
    {
        echo __METHOD__ . "\n";
    }
}
class ConnectPdo extends Base
{
    public function __construct(string $dsn, string $usr, string $pwd)
    {
        $this->conn = new PDO($dsn, $usr, $pwd);
    }
}
class ConnectMysqli extends Base
{
    public function __construct(string $db, string $usr, string $pwd)
    {
        $this->conn = mysqli_connect('localhost', $usr, $pwd, $db) or die("Unable to Connect\n");
    }
}

$db  = 'test';
$usr = 'fake';
$pwd = 'xyz';
$dsn = 'mysql:host=localhost;dbname=' . $db;
try {
    $pdo = new ConnectPdo($dsn, $usr, $pwd);
} catch (Throwable $t) {
    echo __LINE__ . ':' . get_class($t) . ':' . $t->getMessage();
}
echo "\n";

try {
    $mysql = new ConnectMysqli($db, $usr, $pwd);
} catch (Throwable $t) {
    echo __LINE__ . ':' . get_class($t) . ':' . $t->getMessage();
}
echo "\n";
