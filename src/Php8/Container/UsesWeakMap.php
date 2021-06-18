<?php
// /repo/src/Php7/Container/UsesWeakMap.php
namespace Php8\Container;

use WeakMap;
class UsesWeakMap
{
    public $container;
    public $default;
    public function __construct(array $config = [])
    {
        $this->container = new WeakMap();
        if ($config)
            foreach ($config as $obj)
                $this->container->offsetSet($obj, get_class($obj));
        $this->default = new class () {
            public function filter($value) { return $value; }
        };
    }
    public function get(string $key)
    {
        foreach ($this->container as $idx => $obj)
            if ($idx instanceof $key) return $idx;
        return $this->default;
    }
}
