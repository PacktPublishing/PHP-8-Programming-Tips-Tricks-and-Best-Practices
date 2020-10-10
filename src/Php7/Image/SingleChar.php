<?php
namespace Php7\Image;
// https://www.php.net/manual/en/function.imagettftext.php
/**
 * Creates a single image, by default black on white
 */
class SingleChar
{
	public $image = NULL;
	public $width = 100;
	public $height = 100;
	public $char = '';
	public $fg_config = [];
	public $bg_config = [];
	public $tx_config = [];
	/**
	 * Builds an image based on config specs
	 *
	 * @param int $width
	 * @param int $height
	 * @param string $char
	 * @param array $fg_config : [red, green, blue]
	 * @param array $bg_config : [red, green, blue]
	 * @param array $tx_config : [size, angle, x, y, fontfile]
	 */
	public function __construct(
		int $width = 100,
		int $height = 100,
		string $char = 'A',
		array $txt_config = [])
	{
		$this->width = $width;
		$this->height = $height;
		$this->char = $char;
		$this->fg_config = $fg_config;
		$this->bg_config = $bg_config;
		$this->tx_config = $tx_config;
		$this->image = imagecreate($width, $height);
		$fg = 
	}
	/**
	 * Allocates a color resource
	 *
	 * @param array config : assoc array with these keys: [red, green, blue]
	 * @return resource $color
	 */
	public function colorAlloc(int $red = 0, int $green = 0, int $blue = 0)
	{
		return imagecolorallocate($this->image, $red, $green, $blue);
	} 
}
