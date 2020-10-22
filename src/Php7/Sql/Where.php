<?php
namespace Php7\Sql;

class Where
{
	const ERR_WHERE = 'ERROR: missing WHERE clause';
	public $where = [];
	public function where($a, $b = '', $c = '', $d = '')
	{
		$this->where[] = $a;
		$this->where[] = $b;
		$this->where[] = $c;
		$this->where[] = $d;
		return $this;
	}
	protected function hasWhere()
	{
		return (bool) $this->where;
	}
}
