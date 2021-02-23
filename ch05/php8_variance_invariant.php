<?php
// /repo/ch05/php8_variance_invariant.php
class Looper
{
    public function arr2string(Iterator $a) : string
    {
        $output = '';
        foreach ($a as $item)
            $output .= $item . "\n";
        return $output;
    }
}
$arr = new ArrayIterator(range('A','Z'));
$limit = new LimitIterator($arr, 0, 6);
$loop = new Looper();
echo $loop->arr2string($limit);
