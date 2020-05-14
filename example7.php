<?php

// Create objects
$image = new Imagick('formatura.jpg');
$watermark = new Imagick();
$mask = new Imagick();
$draw = new ImagickDraw();

// Define dimensions
$width = $image->getImageWidth();
$height = $image->getImageHeight();

// Create some palettes
$watermark->newImage($width, $height, new ImagickPixel('grey30'));
$mask->newImage($width, $height, new ImagickPixel('black'));

// Watermark text
$text = 'Copyright'; // Inseri este no como Logo

// Set font properties
$draw->setFont('Bookman-Demi');
$draw->setFontSize(20);
$draw->setFillColor('grey70');

// Position text
$draw->setGravity(Imagick::GRAVITY_SOUTHEAST);

// Draw text on the watermark palette
$watermark->annotateImage($draw, 10, 12, 0, $text);

// Draw text on the mask palette
$draw->setFillColor('white');
$mask->annotateImage($draw, 11, 13, 0, $text);
$mask->annotateImage($draw, 10, 12, 0, $text);
$draw->setFillColor('black');
$mask->annotateImage($draw, 9, 11, 0, $text);

// This is apparently needed for the mask to work
$mask->setImageMatte(false);

// Apply mask to watermark
$watermark->compositeImage($mask, Imagick::COMPOSITE_COPYOPACITY, 0, 0);

// Overlay watermark on image
$image->compositeImage($watermark, Imagick::COMPOSITE_DISSOLVE, 0, 0);

// Set output image format
$image->setImageFormat('png');

// Output the new image
header('Content-type: image/png');
echo $image;

?>
