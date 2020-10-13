<?php
namespace Php8\Image\Strategy;
use Php8\Image\SingleChar;
#[description("Fills image")]
class PlainFill
{
	#[description("Writes text onto image following this strategy")]
	#[SingleChar("char")]
	#[int("x1")]
	#[int("y1")]
	#[int("x2")]
	#[int("y2")]
	#[int("color")]
	#[returns("bool")]
	public static function writeFill(
		SingleChar $char,
		int $x1,
		int $y1,
		int $x2,
		int $y2,
		int $color) : bool
	{
		return \imagefilledrectangle($char->image, $x1, $y1, $x2, $y2, $color);
	}
}
