<?php
// /repo/ch05/php8_variance_subclass.php
abstract class Output
{
    public function __construct(public array $data = []) {}
    public function __toString()
    {
        return $this->getStrOut();
    }
    public abstract function getStrOut() : string;
}
class Html extends Output
{
    public function getStrOut() : string
    {
        header('Content-Type: text/html');
        $output = '<ul><li>';
        $output .= implode('</li><li>', $this->data);
        $output .= '</li></ul>';
        return $output;
    }
}
class Json extends Output
{
    public function getStrOut() : string
    {
        header('Content-Type: application/json');
        return json_encode($this->data);
    }
}
