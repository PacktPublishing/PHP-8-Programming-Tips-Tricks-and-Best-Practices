<?php
namespace Php7\Image\Strategy;
// https://www.php.net/manual/en/function.imagettftext.php
/**
 * Casts a shadow behind the character
 */
interface ImageStrategyInterface
{
	/**
	 * Writes text onto image following this strategy
	 *
	 * @param resource $image
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
		&$image,
		float $size,
		float $angle,
		int $x,
		int $y,
		int $color,
		string $fontFile,
		string $text) : array;
}
