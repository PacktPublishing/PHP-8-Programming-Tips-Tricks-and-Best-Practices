<?php
// /repo/ch05/php8_variance_covariant.php
interface FactoryInterface {
    public function make(array $arr): ArrayObject;
}
class ArrTest extends ArrayObject {
    const DEFAULT_TEST = 'This is a test';
}
class ArrFactory implements FactoryInterface {
    protected $data;
    public function make(array $data): ArrTest {
        $this->data = $data;
        return new ArrTest($this->data);
    }
}
$factory = new ArrFactory();
$obj1 = $factory->make([1,2,3]);
$obj2 = $factory->make(['A','B','C']);
var_dump($obj1, $obj2);
