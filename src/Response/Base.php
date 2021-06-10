<?php
// /repo/src/Reponse/Base.php
namespace Response;
use Traversable;
abstract class Base implements ResponseInterface
{
    protected function getArrayCopy($iter) : array
    {
        if (method_exists($iter, 'getArrayCopy')) {
            $data = $iter->getArrayCopy();
        } elseif ($iter instanceof Traversable) {
            $data = iterator_to_array($iter);
        } else {
            $data = (array) $iter;
        }
        return $data;
    }
}
