<?php
declare(strict_types=1);
namespace Chat\Service;

#[Chat\Service\User]
class User extends Base
{
    const TABLE = 'users';
    #[params("int id")]
    public function findById(int $id)
    {
        $result = [];
        $sql = 'SELECT id,username FROM ' . self::TABLE . ' WHERE id=?';
        $stmt = $this->pdo->prepare($sql);
        if (!empty($stmt)) {
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $result;
    }
    #[params("string username")]
    public function findByUserName(string $username)
    {
        // sanitize
        $username = preg_replace('/[^a-z]/', '', strtolower($username));
        $result = [];
        $sql = 'SELECT id,username FROM ' . self::TABLE . ' WHERE username=?';
        $stmt = $this->pdo->prepare($sql);
        if (!empty($stmt)) {
            $stmt->execute([$username]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $result;
    }
}
