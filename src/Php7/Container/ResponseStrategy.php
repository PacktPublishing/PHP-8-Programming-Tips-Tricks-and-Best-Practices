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
        while ($this->container->valid()) {
            if ($this->container->current() instanceof $key) {
                return $this->container->current();
            }
            $this->container->next();
        }
        $obj = new $key();
        $this->container->attach($obj);
        return $obj;
    }
}
