<?php
declare(strict_types=1);
namespace Chat\Service;

use PDOStatement;
use Chat\Generic\Constants;
#[Chat\Service\Message]
class Message extends Base
{
    const TABLE = 'messages';
    public $created = NULL;
    /**
     * Locates messages where any of the following are true:
     * -- user_from == $username
     * -- user_to   == $username
     * -- user_to   == NULL
     */
    #[Chat\Service\Message\findByUser\username("string")]
    #[Chat\Service\Message\findByUser\opts("array [optional]")]
    #[Chat\Service\Message\findByUser\return("mixed")]
    public function findByUser(string $username, ...$opts) : array|false
    {
        $username = strip_tags(strtolower($username));
        $sql['table'] = self::TABLE;
        $sql['where'] = ['user_from=?',' OR user_to=?'," OR user_to='*'"];
        $sql['order'] = 'created DESC';
        return $this->do_exec([$username,$username], $sql, $opts) ?? FALSE;
    }
    /**
     * saves message
     */
    #[Chat\Service\Message\save\data("array")]
    #[Chat\Service\Message\save\return("int PDOStatement::rowCount")]
    public function save(array $data) : int
    {
        // sanitize data
        $sql = 'INSERT INTO ' . self::TABLE . ' (user_from,user_to,msg,created) VALUES (:from,:to,:msg,:created)';
        $connect = $this->getConnection();
        $stmt = $connect->prepare($sql);
        if (empty($data['created']))
            $data['created'] = date(Constants::DATE_FORMAT);
        $stmt->execute($data);
        return $stmt->rowCount();
    }
    /**
     * removes message by user
     */
    #[Chat\Service\Message\remove\from("string : user_from")]
    #[Chat\Service\Message\save\return("int PDOStatement::rowCount")]
    public function remove(string $from) : int
    {
        $sql = 'DELETE FROM ' . self::TABLE . ' WHERE user_from=?';
        $connect = $this->getConnection();
        $stmt = $connect->prepare($sql);
        $stmt->execute([$from]);
        return $stmt->rowCount();
    }
    /**
     * resets 'messages' table
     */
    #[Chat\Service\Message\reset\return("int PDO::exec() : 0 = failure")]
    public function reset() : int
    {
        // sanitize data
        $sql = 'DELETE FROM ' . self::TABLE;
        $connect = $this->getConnection();
        return $connect->exec($sql);
    }
}

// table structure:
/*
--
-- Table structure for table `messages`
--
CREATE TABLE `messages` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `user_from` char(16) NOT NULL,
  `user_to` char(16) DEFAULT '*',
  `msg` varchar(4096) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
*/
