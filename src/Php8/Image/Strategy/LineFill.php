<?php
namespace Php8\Image\Strategy;
use Php8\Image\SingleChar;
#[description("Adds lines to image background")]
class LineFill
{
	#[description("Writes lines onto image following this strategy")]
	#[SingleChar("char")]
	#[int("num : number of lines")]
	#[returns("void")]
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
