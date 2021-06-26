<?php
// /repo/ch05/php8_variance_contravariant.php
class IterObj extends ArrayIterator {}
abstract class Base {
    public abstract function stringify(IterObj $it);
}
class IterTest extends Base  {
    // going to a "wider" type hint is allowed
    public function stringify(iterable $it) {
        return implode(',', iterator_to_array($it)) . "\n";
    }
}
$test  = new IterTest();
$objIt = new IterObj([1,2,3]);
$arrIt = new ArrayIterator(['A','B','C']);
echo $test->stringify($objIt);
echo $test->stringify($arrIt);
