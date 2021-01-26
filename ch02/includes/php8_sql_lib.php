<?php
// ch02/includes/php8_sql_lib.php
declare(strict_types=1);

define('ERR_WHERE', 'ERROR: missing WHERE clause');
define('ERR_MISSING', 'ERROR: missing FROM and/or columns');

function where(stdClass $obj, ...$args)
{
	$obj->where = (empty($obj->where))
			    ? $args
			    : array_merge($obj->where, $args);
}
function cols(stdClass $obj, array $cols)
{
	$obj->cols = $cols;
}
function from(stdClass $obj, string $table)
{
	$obj->from = $table;
}
function order(stdClass $obj, string $order)
{
	$obj->order = $order;
}
function limit(stdClass $obj, int $num)
{
	$obj->limit = $num;
}
function offset(stdClass $obj, int $num)
{
	$obj->offset = $num;
}
function render(stdClass $obj)
{
	// validate
	if (empty($obj->from) || empty($obj->cols)) {
		throw new InvalidArgumentException(ERR_MISSING);
	}
	$obj->sql = 'SELECT ';
	$obj->sql .= implode(',', $obj->cols) . ' ';
	$obj->sql .= 'FROM ' . $obj->from . ' ';
	if (!empty($obj->where)) {
		$obj->sql .= 'WHERE ' . implode(' ', $obj->where);
	}
	if (!empty($obj->limit) && $obj->limit > 0) {
		$obj->sql .= 'LIMIT ' . $obj->limit . ' ';
	}
	if (!empty($obj->offset) && $obj->offset > 0) {
		$obj->sql .= 'OFFSET ' . $obj->offset . ' ';
	}
	return trim(str_replace('  ', ' ', $obj->sql));
}
