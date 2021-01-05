<?php
// /repo/ch02/php8_arbitrary_exp_new.php
class JsonResponse
{
    public function render($data)
    {
        return json_encode($data, JSON_PRETTY_PRINT);
    }
}
class SerialResponse
{
    public function render($data)
    {
        return serialize($data);
    }
}

$allowed = [
    'json' => 'JsonResponse',
    'text' => 'SerialResponse'
];
$data = ['A' => 111, 'B' => 222, 'C' => 333];
echo (new $allowed[$_GET['type'] ?? 'json'])->render($data);
echo "\n";

