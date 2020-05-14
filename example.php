<?php 

// Open the image to draw a watermark
$image = new Imagick();
$image->readImage(getcwd(). "/goat.jpg");

// Open the watermark image
// Important: the image should be obviously transparent with .png format
$watermark = new Imagick();
$watermark->readImage(getcwd(). "/draft_watermark.png");

// Retrieve size of the Images to verify how to print the watermark on the image
$img_Width = $image->getImageWidth();
$img_Height = $image->getImageHeight();
$watermark_Width = $watermark->getImageWidth();
$watermark_Height = $watermark->getImageHeight();

// Check if the dimensions of the image are less than the dimensions of the watermark
// In case it is, then proceed to 
if ($img_Height < $watermark_Height || $img_Width < $watermark_Width) {
    // Resize the watermark to be of the same size of the image
    $watermark->scaleImage($img_Width, $img_Height);

    // Update size of the watermark
    $watermark_Width = $watermark->getImageWidth();
    $watermark_Height = $watermark->getImageHeight();
}

// Calculate the position
$x = ($img_Width - $watermark_Width) / 2;
$y = ($img_Height - $watermark_Height) / 2;

// Draw the watermark on your image
$image->compositeImage($watermark, Imagick::COMPOSITE_OVER, $x, $y);


// From now on depends on you what you want to do with the image
// for example save it in some directory etc.
// In this example we'll Send the img data to the browser as response
// with Plain PHP
header("Content-Type: image/" . $image->getImageFormat());
echo $image;

// Or if you prefer to save the image on some directory
// Take care of the extension and the path !
// $image->writeImage(getcwd(). "/goat_watermark." . $image->getImageFormat()); 
