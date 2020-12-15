<?php
namespace Php7\Image;
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
    const DEFAULT_WIDTH = 100;
    const DEFAULT_HEIGHT = 100;
    public $text     = '';
    public $fontFile = '';
    public $width    = 0;
    public $height   = 0;
    public $size     = 0;
    public $angle    = 0.00;
    public $textX    = 0;
    public $textY    = 0;
    public $fgColor  = NULL;
    public $bgColor  = NULL;
    public $image    = NULL;
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
        int    $width    = self::DEFAULT_WIDTH,
        int    $height   = self::DEFAULT_HEIGHT,
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
     * @param array|int $r,
     * @param int $g
     * @param int $b]
     * @return int $color
     */
    public function colorAlloc($r, $g = 0, $b = 0)
    {
        if (is_array($r)) {
            [$r, $g, $b] = $r;
        }
        return \imagecolorallocate($this->image, $r, $g, $b);
    }
    /**
     * Fills image background
     *
     * @return void
     */
    public function writeFill()
    {
        PlainFill::writeFill($this, 0, 0, $this->width, $this->height, $this->fgColor);
        PlainFill::writeFill($this, 1, 1, $this->width - self::MARGIN, $this->height - self::MARGIN, $this->bgColor);
    }
    /**
     * Writes text onto image
     * See: https://www.php.net/manual/en/function.imagettftext.php
     * @return array $info : 4 x,y pairs representing bounds of text written
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
