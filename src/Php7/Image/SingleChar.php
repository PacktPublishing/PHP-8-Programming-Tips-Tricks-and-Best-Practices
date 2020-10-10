<?php
namespace Php7\Image;
// https://www.php.net/manual/en/function.imagettftext.php
/**
 * Creates a single image, by default black on white
 */
class SingleChar
{
	const DEFAULT_FG = [0x00, 0x00, 0x00];
	const DEFAULT_BG = [0xFF, 0xFF, 0xFF];
	public $image    = NULL;
	public $width    = 100;
	public $height   = 100;
	public $fontFile = '';
	public $fgColor  = NULL;
	public $bgColor  = NULL;
	public $config   = [];
	/**
	 * Builds an image based on config specs
	 *
	 * @param string $fileFile
	 * @param int $width
	 * @param int $height
	 * @param string $char
	 * @param array $config : [fg : [red, green, blue], bg : [red, green, blue]]
	 */
	public function __construct(
		string $fontFile,
		int    $width    = 100,
		int    $height   = 100,
		array  $config   = [])
	{
		$this->fontFile = $fontFile;
		$this->width    = $width;
		$this->height   = $height;
		$this->config   = $config;
		$this->image    = \imagecreate($width, $height);
		$this->fgColor  = (!empty($config['fg']))
						? $this->colorAlloc($config['fg'])
						: $this->colorAlloc(self::DEFAULT_FG);
		$this->bgColor  = (!empty($config['bg']))
						? $this->colorAlloc($config['bg'])
						: $this->colorAlloc(self::DEFAULT_BG);
	}
	/**
	 * Sets foreground/background color
	 *
	 * $param string "fg" | "bg"
	 * @param int $red
	 * @param int $green
	 * @param int $blue
	 * @return int $color
	 */
	public function setFgBgColor($what, $red, $green, $blue)
	{
		$color = $this->colorAlloc($red, $green, $blue);
		$var   = $what . 'Color';
		$this->$var = $color;
		return $color;
	}
	/**
	 * Allocates a color resource
	 *
	 * @param array $rbg : [red, green, blue]
	 * @return int $color
	 */
	public function colorAlloc(...$rgb)
	{
		if (is_array($rgb[0])) {
			[$r, $g, $b] = $rgb[0];
		} else {
			[$r, $g, $b] = $rgb;
		}
		return \imagecolorallocate($this->image, $r, $g, $b);
	}
	/**
	 * Writes text onto image
	 *
	 * @param float $size
	 * @param float $angle
	 * @param int $x
	 * @param int $y
	 * @param string $text
	 */
	public function writeText(float $size, float $angle, int $x, int $y, string $text)
	{
		\imagefilledrectangle($this->image, 0, 0, $this->width, $this->height, $this->fgColor);
		\imagefilledrectangle($this->image, 1, 1, $this->width - 3, $this->height - 3, $this->bgColor);
		return \imagettftext($this->image, $size, $angle, $x, $y, $this->fgColor, $this->fontFile , $text); 
	}
	/**
	 * Renders image as PNG
	 *
	 * @param string $fn : filename where to write image
	 * @return bool
	 */
	public function save(string $fn)
	{
		return \imagepng($this->image, $fn);
	}
}
