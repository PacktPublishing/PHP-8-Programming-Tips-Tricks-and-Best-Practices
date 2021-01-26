<?php
namespace Php8\Image\Strategy;
use Php8\Image\SingleChar;
#[description("Writes plain text to image")]
class RotateText
{
	const ADJ_FACTOR =  20;
	#[description("Adjusts angle of text")]
	#[SingleChar("char")]
	#[float("angle")]
	public static function writeText(SingleChar $char, float $angle = NULL) : void
	{
		$char->angle = rand(-20, 20);
		$char->angle = ($char->angle < 0) ? $char->angle + 360 : $char->angle;
	}
	#[description("Calculates x,y adjustment")]
	#[SingleChar("char")]
	#[float("offset")]
	#[returns("array : {x,y}")]
	public static function calcXYadjust(SingleChar $char, float $offset) : array
	{
		$x_factor = $char->width / self::ADJ_FACTOR;
		$y_factor = $char->height / self::ADJ_FACTOR;
		$x = $char->textX;
		$y = $char->textY;
		if ($offset > 0) {
			// tilts left
			$y += (int) ($offset / $y_factor);
			$x += (int) ($offset / $x_factor) * 3;
		} else {
			// tilts right
			$y += (int) ($offset / $y_factor) * 3;
			$x += (int) ($offset / $x_factor);
		}
		return [$x, $y];
	}
}
