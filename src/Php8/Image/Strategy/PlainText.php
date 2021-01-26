<?php
namespace Php8\Image\Strategy;
use Php8\Image\SingleChar;
#[description("Writes plain text to image")]
class PlainText
{
	#[description("Writes text onto image following this strategy")]
	#[SingleChar("image")]
	#[float("size")]
	#[float("angle")]
	#[int("x")]
	#[int("y")]
	#[int("color")]
	#[string("fontFile")]
	#[string("text")]
	#[returns("array : 4 x,y pairs representing bounds of text written")]
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
