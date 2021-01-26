<?php
namespace Php8\Image\Strategy;
use Php8\Image\SingleChar;
#[description("Casts a shadow behind the character")]
class Shadow
{
	#[description("Writes shadow text onto image following this strategy")]
	#[description("Parameters must be coordinates of original image")]
	#[SingleChar("char")]
	#[int("offset : shadow offset from original coordinates")]
	#[param("int|array red")]
	#[int("green")]
	#[int("blue")]
	#[returns("array : 4 x,y pairs representing bounds of text written")]
	public static function writeText(
		SingleChar $char,
		int $offset,
		int|array $red   = 0xCC,
		int $green = 0xCC,
		int $blue  = 0xCC) : array
	{
		$x = $char->textX + $offset;
		$y = $char->textY + $offset;
		if (is_array($red))
			[$red, $green, $blue] = $red;
		$color = $char->colorAlloc($red, $green, $blue);
		return \imagettftext($char->image, $char->size, $char->angle, $x, $y, $color, $char->fontFile , $char->text); 
	}
}
