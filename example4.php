<?php 

// Open the image to draw a watermark
$image = new Imagick();
$image->readImage(getcwd(). "/goat.jpg");

// Open the watermark image
// Important: the image should be obviously transparent with .png format
$watermark = new Imagick();
$watermark->readImage(getcwd(). "/watermark_file.png");

// The resize factor can depend on the size of your watermark, so heads up with dynamic size watermarks !
$watermarkResizeFactor = 6;

// Retrieve size of the Images to verify how to print the watermark on the image
$img_Width = $image->getImageWidth();
$img_Height = $image->getImageHeight();
$watermark_Width = $watermark->getImageWidth();
$watermark_Height = $watermark->getImageHeight();

// Resize the watermark with the resize factor value
$watermark->scaleImage($watermark_Width / $watermarkResizeFactor, $watermark_Height / $watermarkResizeFactor);

// Update watermark dimensions
$watermark_Width = $watermark->getImageWidth();
$watermark_Height = $watermark->getImageHeight();

// Draw the watermark on your image (top left corner)
$image->compositeImage($watermark, Imagick::COMPOSITE_OVER, 0, 0);

// From now on depends on you what you want to do with the image
// for example save it in some directory etc.
// In this example we'll Send the img data to the browser as response
// with Plain PHP
header("Content-Type: image/" . $image->getImageFormat());
echo $image;

// Or if you prefer to save the image on some directory
// Take care of the extension and the path !
// $image->writeImage(getcwd(). "/goat_watermark." . $image->getImageFormat()); 
