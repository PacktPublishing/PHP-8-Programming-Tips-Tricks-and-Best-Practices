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
echo "Class Attributes\n";
foreach ($attribs as $obj) {
    echo "\n" . $obj->getName() . "\n";
    echo implode("\t", $obj->getArguments());
}
echo "Method Attributes for colorAlloc()\n";
$reflect = new ReflectionMethod($char, 'colorAlloc');
$attribs = $reflect->getAttributes();
foreach ($attribs as $obj) {
    echo "\n" . $obj->getName() . "\n";
    echo implode("\t", $obj->getArguments());
}
echo "\n";
echo '</pre>';
