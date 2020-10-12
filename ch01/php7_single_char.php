<?php
// /repo/ch01/php7_single_char.php
define('FONT_FILE', __DIR__ . '/../fonts/FreeSansBold.ttf');
define('IMG_DIR', __DIR__ . '/../images');
require_once __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Php7\Image\SingleChar;

// generate random hex number for CAPTCHA
$phrase = bin2hex(random_bytes(4));
$length = strlen($phrase);
$images = [];
for ($x = 0; $x < $length; $x++) {
	$char = new SingleChar($phrase[$x], FONT_FILE);
	$char->writeFill();
	$char->writeText();
	$fn = $x . '_' . substr(basename(__FILE__), 0, -4) . '.png';
	$char->save(IMG_DIR . '/' . $fn);
	$images[] = $fn;
}
include __DIR__ . '/captcha_simple.phtml';
