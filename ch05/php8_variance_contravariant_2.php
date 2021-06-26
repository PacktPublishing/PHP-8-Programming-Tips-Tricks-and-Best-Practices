<?php
// /repo/ch05/php8_variance_contravariant_2.php
// doesn't work in PHP 7 or 8
class User
{
    public $id    = 0;
    public $first = '';
    public $last  = '';
}
abstract class Base
{
    public abstract function __construct(object $user);
}
// cannot go from "wider" type hint _object_  to "narrower" type hint _User_
class Signup extends Base
{
    public $user = NULL;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
