<?php
// /repo/ch05/php8_variance_invariant.php
class User
{
    public $id    = 0;
    public $first = '';
    public $last  = '';
}
class Guest extends User {}
abstract class Base
{
    public abstract function __construct(User $user);
}
class Signup extends Base
{
    public $user = NULL;
    public function __construct(Guest $user)
    {
        $this->user = $user;
    }
}
