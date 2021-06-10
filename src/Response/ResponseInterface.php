<?php
// /repo/src/Reponse/ResponseInterface.php
namespace Response;
use ArrayIterator;
interface ResponseInterface
{
    public function render(ArrayIterator $iter) : string;
}


