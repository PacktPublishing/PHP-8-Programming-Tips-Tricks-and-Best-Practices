<?php
// /repo/ch07/php8_gd_is_resource.php

$fn  = __DIR__ . '/includes/kitten.jpg';
$new = __DIR__ . '/includes/test.png';
$fnt = __DIR__ . '/../fonts/FreeSansBold.ttf';
$img = imagecreatefromjpeg($fn);

if (empty($img))
    exit('<h1>Problem generating image</h1>');

$txt = get_class($img);
$blk = imagecolorallocate($img, 0xFF, 0xFF, 0xFF);
$max_y = imagesy($img);
$max_x = imagesx($img);
imagefttext($img, 64, 0, ((int) $max_x * .6), 100, $blk, $fnt, $txt);
imagepng($img, fopen($new, 'w'));
echo '<img src="/ch07/includes/test.png" width="50%" />';

// new function!
echo '<br>';
echo match (imagegetinterpolation($img)) {
    IMG_BELL => 'Bell filter',
    IMG_BESSEL => 'Bessel filter',
    IMG_BICUBIC => 'Bicubic interpolation',
    IMG_BICUBIC_FIXED => 'Fixed point implementation of the bicubic interpolation',
    IMG_BILINEAR_FIXED => 'Fixed point implementation of the bilinear interpolation (default (also on image creation))',
    IMG_BLACKMAN => 'Blackman window function',
    IMG_BOX => 'Box blur filter',
    IMG_BSPLINE => 'Spline interpolation',
    IMG_CATMULLROM => 'Cubic Hermite spline interpolation',
    IMG_GAUSSIAN => 'Gaussian function',
    IMG_GENERALIZED_CUBIC => 'Generalized cubic spline fractal interpolation',
    IMG_HERMITE => 'Hermite interpolation',
    IMG_HAMMING => 'Hamming filter',
    IMG_HANNING => 'Hanning filter',
    IMG_MITCHELL => 'Mitchell filter',
    IMG_POWER => 'Power interpolation',
    IMG_QUADRATIC => 'Inverse quadratic interpolation',
    IMG_SINC => 'Sinc function',
    IMG_NEAREST_NEIGHBOUR => 'Nearest neighbour interpolation',
    IMG_WEIGHTED4 => 'Weighting filter',
    IMG_TRIANGLE => 'Triangle interpolation',
};
echo '</pre>';
