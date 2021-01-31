<?php
// /repo/src/Php7/Connector/ConnectInterface.php
namespace Php7\Connector;
interface ConnectInterface
{
    public function query(string $sql) : array;
}
