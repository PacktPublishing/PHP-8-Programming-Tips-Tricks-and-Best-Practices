<?php
namespace Php7\Image;
/**
 * Adds method to set Foreground or Background color
 */
trait FgBgTrait
{
	/**
	 * Sets foreground color
	 *
	 * @param int $red
	 * @param int $green
	 * @param int $blue
	 * @return int $color
	 */
	public function setFgColor($red, $green, $blue)
	{
		$this->fgColor = \imagecolorallocate($this->image, $r, $g, $b);
	}
	/**
	 * Sets background color
	 *
	 * @param int $red
	 * @param int $green
	 * @param int $blue
	 * @return int $color
	 */
	public function setBgColor($red, $green, $blue)
	{
		$this->bgColor = \imagecolorallocate($this->image, $r, $g, $b);
	}
}
