<?php
// /repo/ch01/php8_single_char_with_strategies.php
define('NUM_BYTES', 3);
define('FONT_FILE', __DIR__ . '/../fonts/FreeSansBold.ttf');
define('IMG_DIR', __DIR__ . '/../images');
require_once __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Php8\Image\SingleChar;
use Php8\Image\Strategy\ {LineFill,DotFill,Shadow,RotateText};
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
		$func = match ($item) {
			'rotate' => RotateText::writeText($char),
			'line'   => LineFill::writeFill($char, rand(1, 10)),
			'dot'    => DotFill::writeFill($char, rand(10, 20)),
			'shadow' => function ($char) {
				$num = rand(1, 8);
				$r   = rand(0x70, 0xEF);
				$g   = rand(0x70, 0xEF);
				$b   = rand(0x70, 0xEF);
				return Shadow::writeText($char, $num, $r, $g, $b);
			},
			'default' => TRUE
		};
		if (is_callable($func)) $func($char);
	}
	$char->writeText();
	$fn = $x . '_' . substr(basename(__FILE__), 0, -4) . '.png';
	$char->save(IMG_DIR . '/' . $fn);
	$images[] = $fn;
}
include __DIR__ . '/captcha_simple.phtml';
