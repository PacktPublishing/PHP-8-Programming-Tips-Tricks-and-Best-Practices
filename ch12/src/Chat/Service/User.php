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
    public function findById(int $id)
    {
        $result = [];
        $sql['table'] = self::TABLE;
        $sql['cols']  = 'id,username';
        $sql['where'] = ['id=?'];
        return $this->do_exec([$id], $sql);
    }
    /**
     * Locates user entry by ID
     *
     * @param string $username
     * @return array $row : user entry | FALSE
     */
    public function findByUserName(string $username)
    {
        // sanitize
        $username = preg_replace('/[^a-z]/', '', strtolower($username));
        $result = [];
        $sql['table'] = self::TABLE;
        $sql['cols']  = 'id,username';
        $sql['where'] = ['username=?'];
        return $this->do_exec([$username], $sql);
    }
    /**
     * Returns a list of usernames
     *
     * @return array $list
     */
    public function findAllUserNames()
    {
        // sanitize
        $sql['table'] = self::TABLE;
        $sql['cols']  = 'id,username';
        return $this->do_exec([], $sql);
    }
}
