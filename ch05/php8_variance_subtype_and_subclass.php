<?php
// /repo/ch05/php8_variance_subtype_and_subclass.php
include 'php8_variance_subclass.php';
class JsonPlus extends Json
{
    public function getPretty()
    {
        header('Content-Type: application/json');
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}

$data = ['A' => 111, 'B' => 222, 'C' => 333];
$plus = new JsonPlus($data);
echo $plus;
