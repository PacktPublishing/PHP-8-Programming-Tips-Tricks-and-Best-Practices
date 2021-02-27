<?php
// /repo/ch05/php8_bc_break_serializable.php
class A implements Serializable {
    private $a = 'A';
    private $b = 'B';
    private $u = NULL;
    public function serialize() {
        $this->u = new DateTime();
        return serialize(get_object_vars($this));
    }
    public function unserialize($payload) {
        $vars = unserialize($payload);
        foreach ($vars as $key => $val)
            $this->$key = $val;
    }
}
$a1 = new A();
var_dump($a1);
$str = serialize($a1);
$a2 = unserialize($str);
var_dump($a2);
echo "\n";

class B extends A {
    private $c = 'C';
    public function serialize() {
        $this->c = time();
        $parent = parent::serialize();
        $child  = serialize($this->c);
        return serialize([$parent, $child]);
    }
    public function unserialize($payload) {
        [$parent, $child] = unserialize($payload);
        parent::unserialize($parent);
        $this->c = unserialize($child);
    }
}
$old_b = new B();
$str = serialize($old_b);
echo $str . "\n";
$new_b = unserialize($str);
var_dump($new_b);
