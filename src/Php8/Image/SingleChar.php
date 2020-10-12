<?php
namespace Php8\Image;
// https://www.php.net/manual/en/function.imagettftext.php
#[description("Creates a single image, by default black on white")]
class SingleChar
{
	const DEFAULT_FG = [0x00, 0x00, 0x00];
	const DEFAULT_BG = [0xFF, 0xFF, 0xFF];
	public $image    = NULL;
	public $fgColor  = NULL;
	public $bgColor  = NULL;
	#[description("Builds an image based on config specs")]
	#[string("fileFile")]
	#[int("width")]
	#[int("height")]
	#[string("char")]
	public function __construct(
		public string $fontFile = '',
		public int    $width    = 100,
		public int    $height   = 100)
	{
		$this->image    = \imagecreate($width, $height);
		$this->fgColor  = $this->colorAlloc(self::DEFAULT_FG);
		$this->bgColor  = $this->colorAlloc(self::DEFAULT_BG);
	}
	#[description("Sets foreground/background color")]
	#[string("fg|bg")]
	#[int("red")]
	#[int("green")]
	#[int("blue")]
	#[returns("int")]
	public function setFgBgColor(string $what, int $red, int $green, int $blue)
	{
		$color = $this->colorAlloc($red, $green, $blue);
		$var   = $what . 'Color';
		$this->$var = $color;
		return $color;
	}
	#[description("Allocates a color resource")]
	#[param("array rbg : [red, green, blue]")]
	#[returns("int")]
	public function colorAlloc(...$rgb)
	{
		if (is_array($rgb[0])) {
			[$r, $g, $b] = $rgb[0];
		} else {
			[$r, $g, $b] = $rgb;
		}
		return \imagecolorallocate($this->image, $r, $g, $b);
	}
	#[description("Writes text onto image")]
	#[description("Returns array representing 4 pairs x,y coords representing bounds of text")]
	#[float("size")]
	#[float("angle")]
	#[int("x")]
	#[int("y")]
	#[string("text")]
	#[returns("array")]
	public function writeText(float $size, float $angle, int $x, int $y, string $text)
	{
		\imagefilledrectangle($this->image, 0, 0, $this->width, $this->height, $this->fgColor);
		\imagefilledrectangle($this->image, 1, 1, $this->width - 3, $this->height - 3, $this->bgColor);
		return \imagettftext($this->image, $size, $angle, $x, $y, $this->fgColor, $this->fontFile , $text); 
	}
	#[description("Renders image as PNG")]
	#[string("fn")]
	#[returns("bool")]
	public function save(string $fn)
	{
		return \imagepng($this->image, $fn);
	}
}
