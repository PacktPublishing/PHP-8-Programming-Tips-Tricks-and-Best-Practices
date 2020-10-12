<?php
namespace Php7\Image\Strategy;
// https://www.php.net/manual/en/function.imagettftext.php
/**
 * Writes plain text to image
 */
use Php7\Image\SingleChar;
class PlainText
{
	/**
	 * Writes text onto image following this strategy
	 *
	 * @param SingleChar $image
	 * @param float $size
	 * @param float $angle
	 * @param int $x
	 * @param int $y
	 * @param int $color
	 * @param string $fontFile
	 * @param string $text
	 * @return array $info : 4 x,y pairs representing bounds of text written
	 */
	public static function writeText(
		SingleChar $char,
		float $size,
		float $angle,
		int $x,
		int $y,
		int $color,
		string $fontFile,
		string $text) : array
	{
		return \imagettftext($char->image, $size, $angle, $x, $y, $color, $fontFile , $text); 
	}
}
