<?php
// /repo/ch01/php8_attrib_reflect.php
define('FONT_FILE', __DIR__ . '/../fonts/FreeSansBold.ttf');
require_once __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Php8\Image\SingleChar;

$char    = new SingleChar('A', FONT_FILE);
$reflect = new ReflectionObject($char);
$attribs = $reflect->getAttributes();
echo "Class Attributes\n";
echo '<pre>';
foreach ($attribs as $obj) {
	var_dump($obj->getName());
	var_dump($obj->getArguments());
}
echo '</pre>';
echo "Method Attributes for colorAlloc()\n";
echo '<div class="row">';
$reflect = new ReflectionMethod($char, 'colorAlloc');
$attribs = $reflect->getAttributes();
foreach ($attribs as $obj) {
	echo '<div class="col-md-4">';
	echo '<pre>';
	var_dump($obj->getName());
	var_dump($obj->getArguments());
	echo '</pre>';
	echo '</div>';
}
echo '</div>';
