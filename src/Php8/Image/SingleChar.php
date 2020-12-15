<?php
namespace Php8\Image;
use Attribute;
use Php8\Image\Strategy\ {PlainText,PlainFill};

#[SingleChar]
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
    #[SingleChar\__construct\description("Builds an image based on config specs")]
    #[SingleChar\__construct\param("text","string")]
    #[SingleChar\__construct\param("fontFile","string","location of font file used for CAPTCHA")]
    #[SingleChar\__construct\param("width","int")]
    #[SingleChar\__construct\param("height","int")]
    #[SingleChar\__construct\param("size","int","size of CAPTCHA text")]
    #[SingleChar\__construct\param("angle","float","value from 0 to 360")]
    #[SingleChar\__construct\param("textX","int","top left X coord of CAPTCHA text")]
    #[SingleChar\__construct\param("textY","int","top left Y coord of CAPTCHA text")]
    #[SingleChar\__construct\returns("void")]
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
    #[SingleChar\colorAlloc\description("Allocates a color resource")]
    #[SingleChar\colorAlloc\param("r","int|array")]
    #[SingleChar\colorAlloc\param("g","int")]
    #[SingleChar\colorAlloc\param("b","int")]
    #[SingleChar\colorAlloc\returns("int")]
    public function colorAlloc(int|array $r, int $g = 0, int $b = 0)
    {
        if (is_array($r)) {
                [$r, $g, $b] = $r;
        }
        return \imagecolorallocate($this->image, $r, $g, $b);
    }
    #[SingleChar\writeFill\description("Fills image background")]
    #[SingleChar\writeFill\description("see: https://www.php.net/manual/en/function.imagettftext.php")]
    public function writeFill()
    {
        PlainFill::writeFill($this, 0, 0, $this->width, $this->height, $this->fgColor);
        PlainFill::writeFill($this, 1, 1, $this->width - self::MARGIN, $this->height - self::MARGIN, $this->bgColor);
    }
    #[SingleChar\writeText\description("Writes text onto image")]
    #[SingleChar\writeText\description("See: https://www.php.net/manual/en/function.imagettftext.php")]
    #[SingleChar\writeText\return("array","4 x,y pairs representing bounds of text written")]
    public function writeText()
    {
        return PlainText::writeText(
                $this, $this->size, $this->angle, $this->textX,
                $this->textY, $this->fgColor, $this->fontFile, $this->text);
    }
    #[SingleChar\save\description("Renders image as PNG")]
    #[SingleChar\save\param("fn","string","output image filename")]
    #[SingleChar\save\returns("bool")]
    public function save(string $fn)
    {
        return \imagepng($this->image, $fn);
    }
}
