<?php
// /repo/src/Php7/Connector/ConnectMysqli.php
namespace Php7\Connector;
class ConnectMysqli extends Base
{
    public function __construct(string $db, string $usr, string $pwd)
    {
        $this->conn = mysqli_connect('localhost', $usr, $pwd, $db) or die("Unable to Connect\n");
    }
    public function query(string $sql) : array
    {
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
