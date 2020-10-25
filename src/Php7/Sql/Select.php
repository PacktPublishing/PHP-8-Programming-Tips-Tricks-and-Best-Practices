<?php
namespace Php7\Sql;

use Exception;
class Select extends Where
{
	const ERR_MISSING = 'ERROR: missing FROM and/or columns';
	public $from  = '';
	public $cols  = [];
	public $order  = '';
	public $limit  = 0;
	public $offset  = 0;
	public $sql   = '';
	public function render()
	{
		// validate
		if (!($this->hasFrom() && $this->hasCols())) {
			throw new Exception(self::ERR_MISSING);
		}
		$this->sql = 'SELECT ';
		$this->sql .= implode(',', $this->cols) . ' ';
		$this->sql .= 'FROM ' . $this->from . ' ';
		if ($this->hasWhere()) {
			$this->sql .= 'WHERE ' . implode(' ', $this->where) . ' ';
		}
		if ($this->limit > 0) {
			$this->sql .= 'LIMIT ' . $this->limit . ' ';
		}
		if ($this->offset > 0) {
			$this->sql .= 'OFFSET ' . $this->offset . ' ';
		}
		return trim(str_replace('  ', ' ', $this->sql));
	}
	public function cols(array $cols)
	{
		$this->cols = $cols;
		return $this;
	}
	public function from(string $table)
	{
		$this->from = $table;
		return $this;
	}
	public function order(string $order)
	{
		$this->order = $order;
		return $this;
	}
	public function limit(int $num)
	{
		$this->limit = $num;
		return $this;
	}
	public function offset(int $num)
	{
		$this->offset = $num;
		return $this;
	}
	public function where(...$args)
	{
		$this->where = (empty($obj->where))
					? $args
					: array_merge($obj->where, $args);
	}
	protected function hasFrom()
	{
		return (bool) $this->from;
	}
	protected function hasCols()
	{
		return (bool) $this->cols;
	}
}
