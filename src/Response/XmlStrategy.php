<?php
// /repo/src/Reponse/XmlStrategy.php
namespace Response;
use XMLWriter;
class XmlStrategy extends Base
{
    const PREFIX = 'node_';
    public function render(iterable $iter) : string
    {
        //header('Content-Type: application/xml');
        $arr = $this->getArrayCopy($iter);
        $xw = new XMLWriter();
        $xw->openMemory();
        $xw->startDocument("1.0");
        $xw->startElement('root'    );
        $this->getRecurse($xw, $arr);
        $xw->endDocument();
        return $xw->outputMemory();
    }
    protected function getRecurse(XMLWriter $xw, array $arr)
    {
        foreach ($arr as $key => $value) {
            $idx = (is_string($key)) ? $key : sprintf('element_%08d', $key);
            $xw->startElement($idx);
            if (is_array($value)) {
                $this->getRecurse($xw, $value);
            } else {
                $xw->text((string) $value);
            }
            $xw->endElement();
        }
    }
}


