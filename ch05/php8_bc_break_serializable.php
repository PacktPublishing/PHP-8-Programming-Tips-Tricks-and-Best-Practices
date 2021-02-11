<?php
// /repo/ch05/php8_bc_break_serialization.php
class A implements Serializable {
    private $a = 'A';
    private $b = 'B';
    private $c = 'C';
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
$a = new A();
$str = serialize($a);
$b = unserialize($str);
var_dump($a, $b);
