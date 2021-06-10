<?php
namespace Php7\Container;

use SplObjectStorage;
use Response\ {HtmlStrategy, JsonStrategy, XmlStrategy, TextStrategy};
class ResponseStrategy
{
    public $container;
    public $default;
    public function __construct()
    {
        $this->container = new SplObjectStorage();
        $this->default = new TextStrategy();
    }
    public function get(string $key)
    {
        $found = FALSE;
        foreach ($this->container as $hash => $obj) {
            if ($obj instanceof $key) return $obj;
        }
        $obj = new $key();
        $this->container->attach($obj);
        return $obj;
    }
}
