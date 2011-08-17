<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/**
 * InTechPHP Framework
 *
 * Parses URIs and determines routing support with default, encryption and friendly url
 *
 * @package		InTechPHP
 * @author		Iqbal Maulana
 * @copyright	Copyright (c) 2011, Intelligence Tech, Inc.
 * @license
 * @link		http://intelligencetech.com
 * @since		Version 1.0
 */

// ------------------------------------------------------------------------

/**
* ImageGD Class
*
* @package		InTechPHP
* @subpackage	Plugin
* @category		Libraries
* @author		Iqbal Maulana
*/
 
class ImageGD {
    private $imageSource;
    private $cropWidth;
    private $cropHeight;
    private $originalImageGD = FALSE;
    private $croppedImageGD;

    public function __construct($imageSource, $cropWidth = 150, $cropHeight = 150) {
        $this->imageSource = $imageSource;
        $this->cropWidth = $cropWidth;
        $this->cropHeight = $cropHeight;
    }

    public function Prepare() {
        if( ! $this->imageSource['name']) return FALSE;
        
        if ($this->imageSource['type'] == "image/jpeg" || $this->imageSource['type'] == "image/jpg") {
            $this->originalImageGD = imagecreatefromjpeg($this->imageSource['name']);
        }
        else if ($this->imageSource['type'] == "image/png") {
            $this->originalImageGD = imagecreatefrompng($this->imageSource['name']);
        }
        else if ($this->imageSource['type'] == "image/gif") {
            $this->originalImageGD = imagecreatefromgif($this->imageSource['name']);
        }

        if ($this->originalImageGD === FALSE) return FALSE;
        return TRUE;
    }

    public function Create($quality = 100) {
        header ("Content-type: image/jpeg");
        $this->Crop();
        imagejpeg($this->croppedImageGD, NULL, $quality);
    }

    public function Save($destination, $quality = 100) {
        $this->Crop();
        imagejpeg($this->croppedImageGD, $destination, $quality);
    }

    protected function Crop() {
        if ($this->originalImageGD === FALSE) return FALSE;

        $originalImageSize  = getimagesize($this->imageSource['name']);
        $originalWidth      = $originalImageSize[0];
        $originalHeight     = $originalImageSize[1];

        $this->croppedImageGD = imagecreatetruecolor($this->cropWidth, $this->cropHeight);
        $wm = $originalWidth / $this->cropWidth;
        $hm = $originalHeight / $this->cropHeight;

        $hHeight = $this->cropHeight/2;
        $wHeight = $this->cropWidth/2;

        if ($originalWidth > $originalHeight )
        {
            $adjustedWidth = $originalWidth / $hm;
            $halfWidth     = $adjustedWidth / 2;
            $intWidth      = $halfWidth - $wHeight;

            imagecopyresampled($this->croppedImageGD , $this->originalImageGD ,-$intWidth,0,0,0,
                               $adjustedWidth, $this->cropHeight, $originalWidth , $originalHeight);
        }
        elseif (($originalWidth < $originalHeight ) || ($originalWidth == $originalHeight ))
        {
            $adjustedHeight = $originalHeight / $wm;
            $halfHeight     = $adjustedHeight / 2;
            $intHeight      = $halfHeight - $hHeight;

            imagecopyresampled($this->croppedImageGD , $this->originalImageGD ,0,-$intHeight,0,0, $this->cropWidth,
                               $adjustedHeight, $originalWidth , $originalHeight );
        }
        else {
            imagecopyresampled($this->croppedImageGD , $this->originalImageGD ,0,0,0,0, $this->cropWidth, $this->cropHeight,
                               $originalWidth , $originalHeight );
        }
    }
}
