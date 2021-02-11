<?php
// /repo/ch05/php8_bc_break_serialization.php
class Test extends ArrayObject {
    protected $id = 12345;
    public $name = 'Doug';
    private $key = '';
    public function __construct() {
        $this->key = base64_encode(random_bytes(16));
    }
    public function __serialize() {
        return ['id' => $this->id, 'name' => $this->name];
    }
    public function __unserialize($data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->__construct();
    }
    public function getKey() {
        return $this->key;
    }
}
$test = new Test();
echo "\nOld Key: " . $test->getKey() . "\n";
$str = serialize($test);
echo $str . "\n";
$obj = unserialize($str);
echo "New Key: " . $obj->getKey() . "\n";
