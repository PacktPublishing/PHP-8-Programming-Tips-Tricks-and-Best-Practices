<?php
// /repo/ch09/php7_trait_abstract_signature.php
declare(strict_types=1);
trait Test1 {
    public abstract function add(int $a, int $b) : int;
}
$main = new class () {
    use Test1;
    public function add(float $a, float $b) : float
    {
        return $a + $b;
    }
};
echo $main->add(111.111, 222.222) . "\n";
