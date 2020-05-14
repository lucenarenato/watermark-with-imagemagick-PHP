<?php
// Open the original image
$image = new Imagick();
$image->readImage("image.jpg");

// Open the watermark
$watermark = new Imagick();
$watermark->readImage("watermark.png");

// Overlay the watermark on the original image
$image->compositeImage($watermark, imagick::COMPOSITE_OVER, 0, 0);

// send the result to the browser
header("Content-Type: image/" . $image->getImageFormat());
echo $image;
