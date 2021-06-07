<?php
// /repo/ch09/php7_class_normal.php
namespace Php7\Image\Strategy;

require_once __DIR__ . '/../src/Server/Autoload/Loader.php';
$autoload = new \Server\Autoload\Loader();

// The long way!
$listOld = [
    'Php7\Image\Strategy\DotFill',
    'Php7\Image\Strategy\LineFill',
    'Php7\Image\Strategy\PlainFill',
    'Php7\Image\Strategy\RotateText',
    'Php7\Image\Strategy\Shadow'
];
print_r($listOld);

// list of classes
$listNew = [
    DotFill::class,
    LineFill::class,
    PlainFill::class,
    RotateText::class,
    Shadow::class
];
print_r($listNew);
