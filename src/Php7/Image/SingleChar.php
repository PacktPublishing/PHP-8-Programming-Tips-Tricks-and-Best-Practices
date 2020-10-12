<?php
namespace Php7\Image;
// https://www.php.net/manual/en/function.imagettftext.php
/**
 * Creates a single image, by default black on white
 */
use Php7\Image\Strategy\ {PlainText,PlainFill};
class SingleChar
{
	const MARGIN     = 3;
	const DEFAULT_FG = [0x00, 0x00, 0x00];
	const DEFAULT_BG = [0xFF, 0xFF, 0xFF];
	const DEFAULT_TX_X = 25;
	const DEFAULT_TX_Y = 75;
	const DEFAULT_TX_SIZE  = 60;
	const DEFAULT_TX_ANGLE = 0;
	public $image    = NULL;
	public $width    = 100;
	public $height   = 100;
	public $fontFile = '';
	public $fgColor  = NULL;
	public $bgColor  = NULL;
	public $size     = 0;
	public $angle    = 0.00;
	public $textX    = 0;
	public $textY    = 0;
	use FgBgTrait;
	/**
	 * Builds an image based on config specs
	 *
	 * @param string $text
	 * @param string $fontFile
	 * @param int $width
	 * @param int $height
	 * @param int $size
	 * @param float $angle
	 * @param int $textX : x coordinate of text
	 * @param int $textY : y coordinate of text
	 */
	public function __construct(
		string $text,
		string $fontFile,
		int    $width    = 100,
		int    $height   = 100,
		int    $size     = self::DEFAULT_TX_SIZE,
		float  $angle    = self::DEFAULT_TX_ANGLE,
		int    $textX    = self::DEFAULT_TX_X,
		int    $textY    = self::DEFAULT_TX_Y)
	{
		$this->text     = $text;
		$this->fontFile = $fontFile;
		$this->width    = $width;
		$this->height   = $height;
		$this->size     = $size;
		$this->angle    = $angle;
		$this->textX    = $textX;
		$this->textY    = $textY;
		$this->image    = \imagecreate($width, $height);
		$this->fgColor  = $this->colorAlloc(self::DEFAULT_FG);
		$this->bgColor  = $this->colorAlloc(self::DEFAULT_BG);
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
	 * Fills image background
	 *
	 */
	public function writeFill()
	{
		PlainFill::writeFill($this->image, 0, 0, $this->width, $this->height, $this->fgColor);
		PlainFill::writeFill($this->image, 1, 1, $this->width - self::MARGIN, $this->height - self::MARGIN, $this->bgColor);
	}
	/**
	 * Writes text onto image
	 *
	 * @param string $text
	 */
	public function writeText()
	{
		return PlainText::writeText(
			$this, $this->size, $this->angle, $this->textX,
			$this->textY, $this->fgColor, $this->fontFile, $this->text);
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
