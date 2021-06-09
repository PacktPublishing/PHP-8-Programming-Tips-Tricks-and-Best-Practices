<?php
// /repo/src/Php8/Sort/Access.php
namespace Php8\Sort;
class Access
{
    public $name, $time;
    public function __construct($name, $time)
    {
        $this->name = $name;
        $this->time = $time;
    }
}
