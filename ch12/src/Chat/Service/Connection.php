<?php
namespace Chat\Service;

use PDO;
class Connection
{
    const CONFIG = __DIR__ . '/../../../config/config.php';
    public static $pdo = NULL;
    private function __construct() {}
    public static function getInstance(string $configFn = NULL)
    {
        if (empty(self::$pdo)) {
            $config = require ($configFn ?? self::CONFIG);
            $dsn = $config['db-config']['dsn'] ?? '';
            $usr = $config['db-config']['usr'] ?? '';
            $pwd = $config['db-config']['pwd'] ?? '';
            self::$pdo = new PDO($dsn, $usr, $pwd);
        }
        return self::$pdo;
    }
}
