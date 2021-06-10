<?php
// /repo/src/Reponse/JsonStrategy.php
namespace Response;

class JsonStrategy extends Base
{
    public function render(iterable $iter) : string
    {
        //header('Content-Type: application/json');
        return json_encode($this->getArrayCopy($iter));
    }
}


