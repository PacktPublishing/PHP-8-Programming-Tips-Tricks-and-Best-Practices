<?php
// /repo/src/Php7/Reflection/Test.php
namespace Php7\Reflection;
use PDO;
use Generator;
class Test
{
    public $pdo = NULL;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function fetchAll() : Generator
    {
        $sql = 'SELECT * FROM customers';
        $stmt = $this->pdo->query($sql);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            yield new ArrayObject($row);
        }
    }
    public function fetchByName(string $name) : array
    {
        $result = [];
        $sql = 'SELECT * FROM customers WHERE name = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([escapeshellcmd($name)]);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new ArrayObject($row);
        }
        return $result;
    }
    public function fetchLastId() : int
    {
        return $this->pdo->lastInsertId();
    }
}
