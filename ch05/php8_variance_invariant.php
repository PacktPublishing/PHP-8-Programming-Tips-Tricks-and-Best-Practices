<?php
// /repo/ch05/php8_variance_invariant.php
class Listing
{
    public function list(ArrayIterator $arr) : array
    {
        return $arr->getArrayCopy();
    }
}
class Limiter extends Listing
{
    public function list(LimitIterator $arr) : array
    {
        return $arr->getArrayCopy();
    }
}

$arr = new ArrayIterator(range('A','Z'));
$list = new Listing();
var_dump($list->list($arr));

$limit = new LimitIterator($arr, 0, 6);
$limiter = new Limiter();
var_dump($limiter->list($limit));

