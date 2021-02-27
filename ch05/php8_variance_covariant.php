<?php
// /repo/ch05/php8_variance_covariant.php
class Listing
{
    public $arr = [];
    public function __construct(array $arr = [])
    {
        $this->arr = $arr;
    }
    public function list() : ArrayIterator
    {
        return new ArrayIterator($this->arr);
    }
}
class Limiter extends Listing
{
    public function list($start, $length) : ArrayIterator
    {
        $iter = parent::list();
        return new I($iter, $start, $length);
    }
}

$limit = new Limiter(range('A','Z'), 0, 6);
foreach ($limit->list as $letter) echo $letter;
