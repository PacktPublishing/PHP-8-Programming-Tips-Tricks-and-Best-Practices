<?php
namespace Php7\Image\Strategy;
// https://www.php.net/manual/en/function.imagettftext.php
/**
 * Adds lines to image background
 */
use Php7\Image\SingleChar;
class LineFill
{
	/**
	 * Writes lines onto image following this strategy
	 *
	 * @param SingleChar $char
	 * @param int $num : number of lines
	 * @return void
	 */
	public static function writeFill(SingleChar $char, int $num) : void
	{
		for ($x = 0; $x < $num; $x++) {
			// calc random x1, y1 (start)
			$x1 = rand(1, $char->width - SingleChar::MARGIN);
			$y1 = rand(1, $char->height - SingleChar::MARGIN);
			// calc random x2, y2 (end)
			$x2 = rand(1, $char->width - SingleChar::MARGIN);
			$y2 = rand(1, $char->height - SingleChar::MARGIN);
			// calc random color
			$r = rand(0,255);
			$g = rand(0,255);
			$b = rand(0,255);
			$color = \imagecolorallocate($char->image, $r, $g, $b);
			\imageline($char->image, $x1, $y1, $x2, $y2, $color);
		}
	}
}
