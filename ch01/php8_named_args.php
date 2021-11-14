<?php
// /repo/ch01/php8_named_args.php
define('FONT_FILE', __DIR__ . '/../fonts/FreeSansBold.ttf');
define('IMG_DIR', __DIR__ . '/../images');
require_once __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Php8\Image\SingleChar;
use Php8\Image\Strategy\RotateText;

// setup basic image w/ white background
$char = new SingleChar('A', FONT_FILE);
$baseFn = substr(basename(__FILE__), 0, -4);

// write a set of images slowly rotating
$images = [];
$rotation = range(40, -40, 10);
foreach ($rotation as $key => $offset) {
    $char->writeFill();
    [$x, $y] = RotateText::calcXYadjust($char, $offset);
    $angle = ($offset > 0) ? $offset : 360 + $offset;
    imagettftext(angle    : $angle,
                 color    : $char->fgColor,
                 image    : $char->image,
                 size     : 60,
                 x        : $x,
                 y        : $y,
                 text     : $char->text,
                 font_filename : FONT_FILE,
    );
    $fn = IMG_DIR . '/' . $baseFn . '_' . $key . '.png';
    imagepng($char->image, $fn);
    $images[] = basename($fn);
}
include __DIR__ . '/captcha_simple.phtml';
