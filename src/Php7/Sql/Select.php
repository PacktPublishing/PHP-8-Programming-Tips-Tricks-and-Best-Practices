<?php
namespace Php7\Sql;

use Exception;
class Select extends Where
{
	const ERR_MISSING = 'ERROR: missing FROM and/or columns';
	public $from  = '';
	public $cols  = [];
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
			$this->sql .= 'WHERE ' . implode(' ', $this->where);
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
	protected function hasFrom()
	{
		return (bool) $this->from;
	}
	protected function hasCols()
	{
		return (bool) $this->cols;
	}
}
