<?php
// /repo/ch01/php8_single_char_with_strategies.php
define('NUM_BYTES', 3);
define('FONT_FILE', __DIR__ . '/../fonts/FreeSansBold.ttf');
define('IMG_DIR', __DIR__ . '/../images');
require_once __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Php8\Image\SingleChar;
use Php8\Image\Strategy\ {LineFill,DotFill,Shadow,RotateText};
// load strategies
$strategies = [
	'rotate',
	'line',
	'dot',
	'shadow',
	'dot',
	'shadow',
	'default'
];
// generate random hex number for CAPTCHA
$phrase = strtoupper(bin2hex(random_bytes(NUM_BYTES)));
$length = strlen($phrase);
$images = [];
for ($x = 0; $x < $length; $x++) {
	$char = new SingleChar($phrase[$x], FONT_FILE);
	$char->writeFill();
	foreach ($strategies as $item) {
		$func = match ($item) {
			'rotate' => function ($char) { return RotateText::writeText($char); },
			'line'   => function ($char) {
				$num = rand(1, 10);
				return LineFill::writeFill($char, $num);
			},
			'dot' => function ($char) {
				$num = rand(10, 20);
				return DotFill::writeFill($char, $num);
			},
			'shadow' => function ($char) {
				$num = rand(1, 8);
				$red = rand(0x70, 0xEF);
				$green = rand(0x70, 0xEF);
				$blue = rand(0x70, 0xEF);
				return Shadow::writeText($char, $num, $red, $green, $blue);
			},
			'default' => function ($char) { return TRUE; }
		};
		$func($char);
	}
	$char->writeText();
	$fn = $x . '_' . substr(basename(__FILE__), 0, -4) . '.png';
	$char->save(IMG_DIR . '/' . $fn);
	$images[] = $fn;
}
include __DIR__ . '/captcha_simple.phtml';
