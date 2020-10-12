<?php
namespace Php7\Image\Strategy;
// https://www.php.net/manual/en/function.imagettftext.php
/**
 * Casts a shadow behind the character
 */
use Php7\Image\SingleChar;
class Shadow
{
	/**
	 * Writes shadow text onto image following this strategy
	 * Parameters must be coordinates of original image
	 * 
	 * @param SingleChar $image
	 * @param int $offset : shadow offset from original coordinates
	 * @param int $red
	 * @param int $green
	 * @param int $blue
	 * @return array $info : 4 x,y pairs representing bounds of text written
	 */
	public static function writeText(
		SingleChar $char,
		int $offset,
		int $red = 0xCC,
		int $green = 0xCC,
		int $blue = 0xCC) : array
	{
		$x = $char->textX + $offset;
		$y = $char->textY + $offset;
		$color = $char->colorAlloc($red, $green, $blue);
		return \imagettftext($char->image, $char->size, $char->angle, $x, $y, $color, $char->fontFile , $char->text); 
	}
}
