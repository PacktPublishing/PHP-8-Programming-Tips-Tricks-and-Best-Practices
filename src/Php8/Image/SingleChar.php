<?php
namespace Php8\Image;
use Php8\Image\Strategy\ {PlainText,PlainFill};
#[description("Creates a single image, by default black on white")]
class SingleChar
{
	const MARGIN     = 3;
	const DEFAULT_FG = [0x00, 0x00, 0x00];
	const DEFAULT_BG = [0xFF, 0xFF, 0xFF];
	const DEFAULT_TX_X = 25;
	const DEFAULT_TX_Y = 75;
	const DEFAULT_TX_SIZE  = 60;
	const DEFAULT_TX_ANGLE = 0;
	const DEFAULT_WIDTH = 100;
	const DEFAULT_HEIGHT = 100;
	public $image    = NULL;
	public $fgColor  = NULL;
	public $bgColor  = NULL;
	#[description("Builds an image based on config specs")]
	#[
		string("text"),
		string("fontFile"),
		int("width"),
		int("height"),
		int("size"),
		float("angle"),
		int("textX"),
		int("textY")
	]
	public function __construct(
		public string $text,
		public string $fontFile,
		public int    $width    = self::DEFAULT_WIDTH,
		public int    $height   = self::DEFAULT_HEIGHT,
	    public int    $size     = self::DEFAULT_TX_SIZE,
	    public float  $angle    = self::DEFAULT_TX_ANGLE,
	    public int    $textX    = self::DEFAULT_TX_X,
	    public int    $textY    = self::DEFAULT_TX_Y)
	{
		$this->image    = \imagecreate($width, $height);
		$this->fgColor  = $this->colorAlloc(self::DEFAULT_FG);
		$this->bgColor  = $this->colorAlloc(self::DEFAULT_BG);
	}
	#[description("Allocates a color resource")]
	#[param("int|array r")]
	#[int("g")]
	#[int("b")]
	#[returns("int")]
	public function colorAlloc(int|array $r, int $g = 0, int $b = 0)
	{
		if (is_array($r)) {
			[$r, $g, $b] = $r;
		}
		return \imagecolorallocate($this->image, $r, $g, $b);
	}
	#[description("Fills image background")]
	#[description("see: https://www.php.net/manual/en/function.imagettftext.php")]
	public function writeFill()
	{
		PlainFill::writeFill($this, 0, 0, $this->width, $this->height, $this->fgColor);
		PlainFill::writeFill($this, 1, 1, $this->width - self::MARGIN, $this->height - self::MARGIN, $this->bgColor);
	}
	#[description("Writes text onto image")]
	#[description("See: https://www.php.net/manual/en/function.imagettftext.php")]
	#[string("text")]
	public function writeText()
	{
		return PlainText::writeText(
			$this, $this->size, $this->angle, $this->textX,
			$this->textY, $this->fgColor, $this->fontFile, $this->text);
	}
	#[description("Renders image as PNG")]
	#[string("fn : filename where to write image")]
	#[returns("bool")]
	public function save(string $fn)
	{
		return \imagepng($this->image, $fn);
	}
}
