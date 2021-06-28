<?php
declare(strict_types=1);
namespace Chat\Service;

#[Chat\Service\Message]
class Message extends Base
{
    const TABLE = 'messages';
    #[params("string username")]
    public function findByFrom(string $username)
    {
        $username = preg_replace('/[^a-z]/', '', strtolower($username));
        $result = [];
        $sql = 'SELECT * FROM ' . self::TABLE . ' WHERE user_from=? ORDER BY created DESC';
        $stmt = $this->pdo->prepare($sql);
        if (!empty($stmt)) {
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $result;
    }
    #[params("string username")]
    public function findByTo(string $username)
    {
        $username = preg_replace('/[^a-z]/', '', strtolower($username));
        $result = [];
        $sql = 'SELECT * FROM ' . self::TABLE . ' WHERE user_to=? OR user_to IS NULL ORDER BY created DESC';
        $stmt = $this->pdo->prepare($sql);
        if (!empty($stmt)) {
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return $result;
    }
    #[params("array $data")]
    public function save(array $data)
    {
        // sanitize data
        $data['created'] = date('Y-m-d H:i:s');
        $sql = 'INSERT INTO ' . self::TABLE . ' (user_from,user_to,created,message) VALUES (:from,:to,:created,:message)';
        return $result;
    }
}
