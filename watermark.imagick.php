<?php

// Watermark with Imagick

// load images
$image = new Imagick("formatura.jpg");
$watermark = new Imagick("logo-wh-new.png");
// translate named gravity to pixel position
$position = gravity2coordinates($image, $watermark, 'lowerRight', 5, 5);
// compose watermark onto image
$image->compositeImage( $watermark, $watermark->getImageCompose(), $position['x'], $position['y'] );
// you'll never guess what this does…
$image->writeImage("result.jpg");

function gravity2coordinates($image, $watermark, $gravity, $xOffset=0, $yOffset=0) {
	// theoretically this should work
	// $im->setImageGravity( Imagick::GRAVITY_SOUTHEAST );
	// but it doesn't so here goes the workaround
	
	switch ($gravity) {
		case 'upperLeft':
			$x = $xOffset;
			$y = $yOffset;
			break;
		
		case 'upperRight':
			$x = $image->getImageWidth() - $watermark->getImageWidth() - $xOffset;
			$y = $yOffset;
			break;
		
		case 'lowerRight':
			$x = $image->getImageWidth() - $watermark->getImageWidth() - $xOffset;
			$y = $image->getImageHeight() - $watermark->getImageHeight() - $yOffset;
			break;
		
		case 'lowerLeft':
			$x = $xOffset;
			$y = $image->getImageHeight() - $watermark->getImageHeight() - $yOffset;
			break;
	}

	return array(
		'x' => $x, 
		'y' => $y
	);
}
?>
