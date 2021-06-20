<?php
namespace Server\Autoload;
/**
 * Loads source code for this branch
 */
class Loader
{
    const DEFAULT_SRC = __DIR__ . '/../..';
    public $src_dir = '';
    public $test_dir = '';
    public function __construct(string $src_dir = NULL, string $test_dir = NULL)
    {
        $this->src_dir = $src_dir ?? realpath(self::DEFAULT_SRC);
        $this->test_dir = $test_dir ?? realpath($this->src_dir . '../test');
        spl_autoload_register([$this, 'autoload']);
        spl_autoload_register([$this, 'testAutoload']);
    }
    public function autoload($class)
    {
        $this->load($class, $this->src_dir);
    }
    public function testAutoload($class)
    {
        $this->load($class, $this->test_dir);
    }
    protected function load($class, $dir)
    {
        $fn = str_replace('\\', '/', $class);
        $fn = $dir . '/' . $fn . '.php';
        $fn = str_replace('//', '/', $fn);
        require($fn);
    }
}
