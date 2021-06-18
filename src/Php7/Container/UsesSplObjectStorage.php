<?php
// /repo/src/Php7/Container/UsesSplObjectStorage.php
namespace Php7\Container;

use SplObjectStorage;
class UsesSplObjectStorage
{
    public $container;
    public $default;
    public function __construct(array $config = [])
    {
        $this->container = new SplObjectStorage();
        if ($config)
            foreach ($config as $obj)
                $this->container->attach($obj, get_class($obj));
        $this->default = new class () {
            public function filter($value) { return $value; }
        };
    }
    public function get(string $key)
    {
        foreach ($this->container as $idx => $obj)
            if ($obj instanceof $key) return $obj;
        return $this->default;
    }
}
