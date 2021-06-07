<?php
// /src/Php8/Sql/Where.php
namespace Php8\Sql;

class Where
{
    const ERR_WHERE = 'ERROR: missing WHERE clause';
    public $where = [];
    public function where(...$args) : static
    {
        $this->where = array_merge($this->where, $args);
        return $this;
    }
    protected function hasWhere()
    {
        return (bool) $this->where;
    }
}
