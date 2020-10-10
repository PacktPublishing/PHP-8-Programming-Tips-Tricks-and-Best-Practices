<?php
// /repo/ch01/php7_single_char.php
define('SRC_DIR', realpath(__DIR__ . '/../src'));
define('FONT_FILE', __DIR__ . '/../fonts/FreeSansBold.ttf');
define('IMG_DIR', __DIR__ . '/../images');
include __DIR__ . '/../src/Php7/Autoload/Loader.php';
$loader = new Php7\Autoload\Loader(SRC_DIR);
use Php7\Image\SingleChar;

// generate random hex number for CAPTCHA
$phrase = bin2hex(random_bytes(4));
$length = strlen($phrase);
$images = [];
for ($x = 0; $x < $length; $x++) {
	$char = new SingleChar(FONT_FILE);
	$char->writeText(60, 0, 25, 75, $phrase[$x]);
	$fn = $x . '_' . substr(basename(__FILE__), 0, -4) . '.png';
	$char->save(IMG_DIR . '/' . $fn);
	$images[] = $fn;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title><?= basename(__FILE__); ?></title>
<meta name="generator" content="Geany 1.36" />
</head>
<body>
	<?php foreach ($images as $fn) : ?>
	<img src="/images/<?= $fn ?>" />
	<?php endforeach; ?>
</body>
</html>


