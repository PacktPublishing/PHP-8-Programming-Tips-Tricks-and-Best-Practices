<?php
namespace Services;
use Closure;
class HashGen
{
    public $class = 'HashGen: ';
    /**
     * Returns an anonymous function that produces the desired hash
     * @param string $type : md5 | sha256
     * @return Closure
     */
    public function makeHash(string $type)
    {
        $method = 'hashTo' . ucfirst($type);
        if (method_exists($this, $method)) {
            return Closure::fromCallable([$this, $method]);
        } else {
            return Closure::fromCallable([$this, 'doNothing']);
        }
    }
    protected function doNothing(string $text)
    {
        return $text;
    }
    protected function hashToMd5(string $text)
    {
        return $this->class . md5($text);
    }
    protected function hashToSha256(string $text)
    {
        return $this->class . hash('sha256', $text);
    }
}
