<?php
// Create objects
$image = new Imagick('image.jpg');

// Watermark text
$text = 'Copyright';

// Create a new drawing palette
$draw = new ImagickDraw();

// Set font properties
$draw->setFont('Ubuntu');
$draw->setFontSize(20);
$draw->setFillColor('black');

// Position text at the bottom-right of the image
$draw->setGravity(Imagick::GRAVITY_SOUTHEAST);

// Draw text on the image
$image->annotateImage($draw, 10, 12, 0, $text);

// Draw text again slightly offset with a different color
$draw->setFillColor('white');
$image->annotateImage($draw, 11, 11, 0, $text);

// Set output image format
$image->setImageFormat('png');

// Output the new image
header('Content-type: image/png');
echo $image;
