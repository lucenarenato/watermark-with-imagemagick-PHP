<?php

/**
 * LICENSE
 *
 * This source file is subject to the GNU General Public License, Version 3
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @category   OpenCart
 * @package    Imagick Library for OpenCart 2.0
 * @copyright  Copyright (c) 2015 Eugene Lifescale by OpenCart Ukrainian Community (http://opencart-ukraine.tumblr.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License, Version 3
 */

class Image {

    private $_image;
    private $_info;

    public function __construct($file) {

        if (file_exists($file)) {

            $this->_image = new Imagick();
            $this->_image->readImage($file);

            $this->_info = array(
                'width'  => $this->_image->getImageWidth(),
                'height' => $this->_image->getImageHeight(),
                'bits'   => $this->_image->getImageLength(),
                'mime'   => $this->_image->getFormat()
            );

        } else {
            exit('Error: Could not load image ' . $file . '!');
        }
    }

    public function save($file, $quality = 100) {

        // Set image compression
        $this->_image->setCompressionQuality($quality);

        // Set image format
        $this->_image->setImageFormat($this->_info['mime']);

        // Write image to the disk
        $this->_image->writeImage($file);
    }

    public function resize($width = 0, $height = 0, $default = false) {

        // Default behavior required
        if (!$this->_info['width'] || !$this->_info['height']) {
            return;
        }

        switch ($default) {
            case 'w':
                $height = $width;
                break;
            case 'h':
                $width  = $height;
                break;
        }

        // Resize image
        $this->_image->resizeImage($width, $height, false, 1, true);


        if ($width == $height && $this->_info['width'] != $this->_info['height']) {

            // Set original
            $original = $this->_image;

            // Create layout
            $this->_image = new Imagick();
            $this->_image->newImage($width, $height, '#FFFFFF');

            // Composite
            $x = round(($width - $original->getImageWidth()) / 2);
            $y = round(($height - $original->getImageHeight()) / 2);

            $this->_image->compositeImage($original, Imagick::COMPOSITE_OVER, $x, $y);

        }

        // Update dimensions
        $this->_info['width']  = $width;
        $this->_info['height'] = $height;
    }

    public function watermark($file, $position = 'bottomright') {

        // Create watermark image
        $watermark = new Imagick($file);

        // Composite position
        switch($position) {

            case 'overlay':
                for ($w = 0; $w < $this->_info['width']; $w += $watermark->getImageWidth()) {
                    for ($h = 0; $h < $this->_info['height']; $h += $watermark->getImageHeight()) {
                        $this->_image->compositeImage($watermark, Imagick::COMPOSITE_OVER, $w, $h);
                    }
                }
                break;
            case 'topleft':
                $this->_image->compositeImage($watermark,
                                             Imagick::COMPOSITE_OVER,
                                             0,
                                             0);
                break;
            case 'topright':
                $this->_image->compositeImage($watermark,
                                             Imagick::COMPOSITE_OVER,
                                             $this->_info['width'] - $watermark->getImageWidth(),
                                             0);
                break;
            case 'bottomleft':
                $this->_image->compositeImage($watermark,
                                             Imagick::COMPOSITE_OVER,
                                             0,
                                             $this->_info['height'] - $watermark->getImageHeight());
                break;
            case 'bottomright':
                $this->_image->compositeImage($watermark,
                                             Imagick::COMPOSITE_OVER,
                                             $this->_info['width']  - $watermark->getImageWidth(),
                                             $this->_info['height'] - $watermark->getImageHeight());
                break;
        }
    }

    public function crop($top_x, $top_y, $bottom_x, $bottom_y) {

        // Crop image
        $this->_image->cropImage($top_x, $top_y, $bottom_x, $bottom_y);

        // Update dimensions
        $this->_info['width']  = $bottom_x - $top_x;
        $this->_info['height'] = $bottom_y - $top_y;
    }

    public function rotate($degree, $color = 'FFFFFF') {

        // Rotate image
        $this->_image->rotateimage($color, $degree);
    }
}
