<?php
// /repo/ch05/php8_variance_subtype.php
include 'php8_variance_subclass.php';
class Test
{
    public function __construct(public array $data = []) {}
    public function __toString()
    {
        header('Content-Type: application/json');
        return json_encode($this->data);
    }
}

$data = ['A' => 111, 'B' => 222, 'C' => 333];
$json = new Json($data);
echo $json;

$test = new Test($data);
echo $test;
