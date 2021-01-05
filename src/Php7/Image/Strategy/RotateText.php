<?php
namespace Php7\Image\Strategy;
// https://www.php.net/manual/en/function.imagettftext.php
/**
 * Writes plain text to image
 */
use Php7\Image\SingleChar;
class RotateText
{
	/**
	 * Adjusts angle of text 
	 *
	 * @param SingleChar $char
	 * @param float $angle
	 */
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
