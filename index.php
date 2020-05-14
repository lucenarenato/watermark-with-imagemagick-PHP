<?php 

// Create instance of the original image
$image = new Imagick();
$image->readImage("formatura.jpg");

// Create instance of the Watermark image
$watermark = new Imagick();
$watermark->readImage("watermark.png");

// The start coordinates where the file should be printed
$x = 0;
$y = 0;

// Draw watermark on the image file with the given coordinates
$image->compositeImage($watermark, Imagick::COMPOSITE_OVER, $x, $y);

// Save image
$image->writeImage("image_watermark." . $image->getImageFormat()); 

?>
