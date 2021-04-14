<?php
// /repo/ch067/php7_gd_is_resource.php

$fn  = __DIR__ . '/includes/kitten.jpg';
$new = __DIR__ . '/includes/test.png';
$fnt = __DIR__ . '/../fonts/FreeSansBold.ttf';
$img = imagecreatefromjpeg($fn);

if (!is_resource($img))
    exit('<h1>Problem generating image</h1>');

$txt = (string) $img;
$blk = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);
$max_y = imagesy($img);
$max_x = imagesx($img);
imagefttext($img, 64, 0, ((int) $max_x * .6), 100, $blk, $fnt, $txt);
imagepng($img, fopen($new, 'w'));
echo '<img src="/ch07/includes/test.png" width="50%" />';
