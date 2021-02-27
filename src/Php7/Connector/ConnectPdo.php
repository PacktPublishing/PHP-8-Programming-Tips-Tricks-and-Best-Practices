<?php
// /repo/src/Php7/Connector/ConnectPdo.php
namespace Php7\Connector;
use PDO;
class ConnectPdo extends Base
{
    public function __construct(string $dsn, string $usr, string $pwd)
    {
        $this->conn = new PDO($dsn, $usr, $pwd);
    }
    public function query(string $sql) : array
    {
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
