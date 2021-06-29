<?php
declare(strict_types=1);
namespace Chat\Service;

use PDOStatement;
use Chat\Generic\Constants;
#[Chat\Service\Message]
class Message extends Base
{
    const TABLE = 'messages';
    /**
     * Locates messages based on 'from'
     *
     * @param string $username
     * @param array $opts : options [optional]
     * @return mixed $result
     */
    public function findByFrom(string $username, ...$opts)
    {
        $username = preg_replace('/[^a-z]/', '', strtolower($username));
        $sql['table'] = self::TABLE;
        $sql['where'] = ['user_from=?'];
        $sql['order'] = 'created DESC';
        return $this->do_exec([$username], $sql, $opts);
    }
    /**
     * Locates messages based on _to_
     *
     * @param string $username
     * @param array $opts : options [optional]
     * @return mixed $result
     */
    public function findByTo(string $username, ...$opts)
    {
        $username = preg_replace('/[^a-z]/', '', strtolower($username));
        $result = [];
        $sql['where'] = ['user_to=?', 'OR user_to IS NULL'];
        $sql['order'] = 'created DESC';
        return $this->do_exec([$username], $sql, $opts);
    }
    /**
     * saves message
     *
     * @param array $data
     * @return int $stmt->rowCount() : 0 = failure
     */
    public function save(array $data) : int
    {
        // sanitize data
        $data['created'] = date('Y-m-d H:i:s');
        $sql = 'INSERT INTO ' . self::TABLE . ' (user_from,user_to,created,message) VALUES (:from,:to,:created,:message)';
        $connect = $this->getConnection();
        $stmt = $connect->prepare($sql);
        $stmt->execute($data);
        return $stmt->rowCount();
    }
}
