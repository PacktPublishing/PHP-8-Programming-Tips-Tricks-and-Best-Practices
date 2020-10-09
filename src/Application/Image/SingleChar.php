<?php
namespace Application\Image;
// https://www.php.net/manual/en/function.imagettftext.php
@@description('Creates a single image, by default black on white')
class SingleChar
{
	public $image = NULL;
	@@param('int $width')
	@@param('int $height')
	@@param('string $char')
	@@param('array $config : [size, angle, x, y, fontfile]')
	public function __construct(
		public int $width = 100,
		public int $height = 100,
		public string $char = 'A',
		public array $config = [])
	{
		$this->image = imagecreate($width, $height);
		$fg = imagecolorallocate(
	}
}
