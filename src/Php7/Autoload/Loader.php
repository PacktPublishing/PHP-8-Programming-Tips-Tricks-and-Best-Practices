<?php
namespace Php7\Autoload;
// https://www.php.net/manual/en/function.imagettftext.php
/**
 * Creates a single image, by default black on white
 */
class Loader
{
	public $src_dir = '';
	public function __construct(string $src_dir)
	{
		$this->src_dir = $src_dir;
		spl_autoload_register([$this, 'autoload']);
	}
	public function autoload($class)
	{
		$fn = str_replace('\\', '/', $class);
		$fn = $this->src_dir . '/' . $fn . '.php';
		$fn = str_replace('//', '/', $fn);
		require_once($fn);
	}
}
