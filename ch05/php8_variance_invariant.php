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

// Fails because child classes can go "wider" than the parent, but not "narrower"
// but in this case the data type is invariant

// output:
/*
Fatal error: Declaration of Signup::__construct(Guest $user) must be compatible with
Base::__construct(User $user) in /repo/ch05/php8_variance_invariant.php on line 17
 */
