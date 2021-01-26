<?php
namespace Php8\Image\Strategy;
use Php8\Image\SingleChar;
#[description("Adds lines to image background")]
class DotFill
{
	#[description("Writes dots onto image following this strategy")]
	#[SingleChar("char")]
	#[int("num : number of dots")]
	#[returns("void")]
	public static function writeFill(SingleChar $char, int $num) : void
	{
		for ($x = 0; $x < $num; $x++) {
			// calc random x1, y1 (start)
			$width = rand(1, 5);
			$x1 = rand(1, $char->width - $width - SingleChar::MARGIN);
			$y1 = rand(1, $char->height - $width - SingleChar::MARGIN);
			$x2 = $x1 + $width;
			$y2 = $y1 + $width;
			// calc random color
			$r = rand(0,255);
			$g = rand(0,255);
			$b = rand(0,255);
			$color = \imagecolorallocate($char->image, $r, $g, $b);
			\imagefilledrectangle($char->image, $x1, $y1, $x2, $y2, $color);
		}
	}
}
