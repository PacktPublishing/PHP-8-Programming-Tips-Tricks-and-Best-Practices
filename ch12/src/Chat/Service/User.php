<?php
declare(strict_types=1);
namespace Chat\Service;

#[Chat\Service\User]
class User extends Base
{
    const TABLE = 'users';
    /**
     * Locates user entry by ID
     *
     * @param int $id
     * @return array $row : user entry | FALSE
     */
    public function findById(int $id) : array|false
    {
        $result = [];
        $sql['table'] = self::TABLE;
        $sql['cols']  = 'id,username';
        $sql['where'] = ['id=?'];
        $result = $this->do_exec([$id], $sql);
        return (!empty($result)) ? current($result) : FALSE;
    }
    /**
     * Locates user entry by ID
     *
     * @param string $username
     * @return array $row : user entry | FALSE
     */
    public function findByUserName(string $username) : array|false
    {
        // sanitize
        $username = preg_replace('/[^a-z]/', '', strtolower($username));
        $result = [];
        $sql['table'] = self::TABLE;
        $sql['cols']  = 'id,username';
        $sql['where'] = ['username=?'];
        $result = $this->do_exec([$username], $sql);
        return (!empty($result)) ? current($result) : FALSE;
    }
    /**
     * Returns a list of usernames
     *
     * @return iterable|NULL $list
     */
    public function findAllUserNames() : iterable|null
    {
        // sanitize
        $sql['table'] = self::TABLE;
        $sql['cols']  = 'id,username';
        $opts['limit'] = 500;
        return $this->do_exec([], $sql, $opts);
    }
}
