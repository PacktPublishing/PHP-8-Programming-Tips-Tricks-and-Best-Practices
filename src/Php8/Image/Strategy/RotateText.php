<?php
namespace Php8\Image\Strategy;
use Php8\Image\SingleChar;
#[description("Writes plain text to image")]
class RotateText
{
	#[description("Adjusts angle of text")]
	#[SingleChar("char")]
	#[float("angle")]
	public static function writeText(
		SingleChar $char,
		float $angle = NULL) : void
	{
		$char->angle = rand(-20, 20);
		$char->angle = ($char->angle < 0) ? $char->angle + 360 : $char->angle;
	}
	/**
	 * If angle = 90, y = 0;
	 * If angle = 180, y = 45
	 * If angle = 270, y = 45
	 */
}
