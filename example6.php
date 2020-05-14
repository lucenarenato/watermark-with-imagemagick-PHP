<?php
$image = new Imagick();
$image->readImage("image.jpg");

$watermark = new Imagick();
$watermark->readImage("watermark.png");

// how big are the images?
$iWidth = $image->getImageWidth();
$iHeight = $image->getImageHeight();
$wWidth = $watermark->getImageWidth();
$wHeight = $watermark->getImageHeight();

if ($iHeight < $wHeight || $iWidth < $wWidth) {
    // resize the watermark
    $watermark->scaleImage($iWidth, $iHeight);

    // get new size
    $wWidth = $watermark->getImageWidth();
    $wHeight = $watermark->getImageHeight();
}

// calculate the position
$x = ($iWidth - $wWidth) / 2;
$y = ($iHeight - $wHeight) / 2;

$image->compositeImage($watermark, imagick::COMPOSITE_OVER, $x, $y);

header("Content-Type: image/" . $image->getImageFormat());
echo $image;
