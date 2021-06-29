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
     * Locates messages where any of the following are true:
     * -- user_from == $username
     * -- user_to   == $username
     * -- user_to   == NULL
     *
     * @param string $username
     * @param array $opts : options [optional]
     * @return mixed $result
     */
    public function findByUser(string $username, ...$opts)
    {
        $username = preg_replace('/[^a-z]/', '', strtolower($username));
        $sql['table'] = self::TABLE;
        $sql['where'] = ['user_from=?',' OR user_to=?',' OR user_to IS NULL'];
        $sql['order'] = 'created DESC';
        return $this->do_exec([$username,$username], $sql, $opts);
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
        $sql = 'INSERT INTO ' . self::TABLE . ' (user_from,user_to,msg) VALUES (:from,:to,:msg)';
        $connect = $this->getConnection();
        $stmt = $connect->prepare($sql);
        $stmt->execute($data);
        return $stmt->rowCount();
    }
    /**
     * removes message by user
     *
     * @param string $username
     * @return int $stmt->rowCount() : 0 = failure
     */
    public function remove(string $username) : int
    {
        // sanitize data
        $sql = 'DELETE FROM ' . self::TABLE . ' WHERE user_from=?';
        $connect = $this->getConnection();
        $stmt = $connect->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->rowCount();
    }
}
