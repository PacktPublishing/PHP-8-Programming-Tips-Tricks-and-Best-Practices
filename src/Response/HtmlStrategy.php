<?php
// /repo/src/Reponse/HtmlStrategy.php
namespace Response;

class HtmlStrategy extends Base
{
    public function render(iterable $iter) : string
    {
        $out = '<ul>';
        $this->getRecurse($out, $this->getArrayCopy($iter));
        $out .= '</ul>';
        return $out;
    }
    protected function getRecurse(string &$html, array $arr)
    {
        foreach ($arr as $key => $value) {
            $html .= '<li>' . $key . ':';
            if (is_array($value)) {
                $html .= '<ul>';
                $html .= $this->getRecurse($html, $value);
                $html .= '</ul>';
            } else {
                $html .= (string) $value;
            }
            $html .= '</li>';
        }
    }
}


