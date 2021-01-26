<?php
// /repo/ch01/php7_single_char_with_strategies.php
define('NUM_BYTES', 3);
define('FONT_FILE', __DIR__ . '/../fonts/FreeSansBold.ttf');
define('IMG_DIR', __DIR__ . '/../images');
require_once __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Php7\Image\SingleChar;
use Php7\Image\Strategy\ {LineFill,DotFill,Shadow,RotateText};
// define strategies
$strategies = [
	'rotate', 'line', 'line',
	'dot', 'dot', 'shadow'
];
// generate random hex number for CAPTCHA
$phrase = strtoupper(bin2hex(random_bytes(NUM_BYTES)));
$length = strlen($phrase);
$images = [];
for ($x = 0; $x < $length; $x++) {
	$char = new SingleChar($phrase[$x], FONT_FILE);
	$char->writeFill();
	shuffle($strategies);
	foreach ($strategies as $item) {
		switch ($item) {
			case 'rotate' :
				RotateText::writeText($char);
				break;
			case 'line' :
				$num = rand(1, 10);
				LineFill::writeFill($char, $num);
				break;
			case 'dot' :
				$num = rand(10, 20);
				DotFill::writeFill($char, $num);
				break;
			case 'shadow' :
				$num = rand(1, 8);
				$red = rand(0x70, 0xEF);
				$green = rand(0x70, 0xEF);
				$blue = rand(0x70, 0xEF);
				Shadow::writeText($char, $num, $red, $green, $blue);
				break;
			default :
				// do nothing
		}
	}
	$char->writeText();
	$fn = $x . '_' . substr(basename(__FILE__), 0, -4) . '.png';
	$char->save(IMG_DIR . '/' . $fn);
	$images[] = $fn;
}
include __DIR__ . '/captcha_simple.phtml';
