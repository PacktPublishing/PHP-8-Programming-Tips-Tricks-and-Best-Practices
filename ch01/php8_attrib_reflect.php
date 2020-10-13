<?php
// /repo/ch01/php8_attrib_reflect.php
define('FONT_FILE', __DIR__ . '/../fonts/FreeSansBold.ttf');
require_once __DIR__ . '/../src/Server/Autoload/Loader.php';
$loader = new \Server\Autoload\Loader();
use Php8\Image\SingleChar;

$char    = new SingleChar('A', FONT_FILE);
$reflect = new ReflectionObject($char);
$attribs = $reflect->getAttributes();
echo '<pre>';
foreach ($attribs as $obj) {
	var_dump($obj->getName());
	var_dump($obj->getArguments());
}
foreach (get_class_methods($char) as $name) {
	$reflect = new ReflectionMethod($char, $name);
	foreach ($reflect->getAttributes() as $obj) {
		var_dump($obj->getName());
		var_dump($obj->getArguments());
	}
}
echo '</pre>';
