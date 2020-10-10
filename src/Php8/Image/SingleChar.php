<?php
namespace Php8\Image;
// https://www.php.net/manual/en/function.imagettftext.php
#[description('Creates a single image, by default black on white')]
class SingleChar
{
	const DEFAULT_FG = [0x00,0x00,0x00];
	const DEFAULT_BG = [0xFF,0xFF,0xFF];
	public $image = NULL;
	public int $fg = 0;
	public int $bg = 0x
	#[int("width")]
	#[int("height")]
	#[string("char")]
	#[array("config : [txt : [size, angle, x, y, fontfile], fg  : [red, green, blue], bg  : [red, green, blue]]")]
	public function __construct(
		public int $width = 100,
		public int $height = 100,
		public string $char = 'A',
		public array $config = [])
	{
		$this->image = imagecreate($width, $height);
		$this->fg    = imagecolorallocate(0, 0, 0);				// black
		$this->bg    = imagecolorallocate(0xFF, 0xFF, 0xFF);	// white
		$this->tx    = NULL;
		if ($config) {
			if (!empty($config['fg'])) {
				['red' => $r, 'green' => $g, 'blue' => $b] = $config['fg'];
				$this->fg = imagecolorallocate($r, $g, $b);
			}
			if (!empty($config['bg'])) {
				['red' => $r, 'green' => $g, 'blue' => $b] = $config['bg'];
				$this->bg = imagecolorallocate($r, $g, $b);
			}
		}
	}
	#[int("red")]
	#[int("green")]
	#[int("blue")]
	public function colorAlloc(...$rgb)
	{
		$color = NULL;
		switch (TRUE) {
			case !empty($rgb) :
				[$r, $g, $b] = $rgb;
				$color = imagecolorallocate($this->image, $r, $g, $b);
				break;
		return 
	}
	#[float("size")]
	#[float("angle")]
	#[int("x")]
	#[int("y")]
	public function writeText(...$txtConfig)
	{
		['size' => $s, 'angle' => $a, 'x' => $x, 'y' => $y, 'fontfile' => $ff] = $config['tx'];			
		imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text ) 
	}
}
