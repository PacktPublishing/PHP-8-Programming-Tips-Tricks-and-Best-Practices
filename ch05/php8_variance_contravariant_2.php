<?php
// /repo/ch05/php8_variance_contravariant.php
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
class Signup extends Base
{
    public $user = NULL;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
