<?php
// /repo/src/Reponse/TextStrategy.php
namespace Response;

class TextStrategy extends Base
{
    public function render(iterable $iter) : string
    {
        //header('Content-Type: text/html');
        $out = '';
        if (!empty($_SERVER['REQUEST_URI'])) {
            $out = '<pre>';
            $this->getRecurse($out, $this->getArrayCopy($iter));
            $out .= '</pre>';
        } else {
            $this->getRecurse($out, $this->getArrayCopy($iter));
        }
        return $out;
    }
    protected function getRecurse(string &$text, array $arr)
    {
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                $text .= $key . ":\n";
                $text .= $this->getRecurse($text, $value);
            } else {
                $text .= $key . ':' . (string) $value . "\n";
            }
        }
    }
}


