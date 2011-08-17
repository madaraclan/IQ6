<?php
	
	class resize{
		
		private $img;
		private $width;
		private $height;
		private $imgResize;
		
		function __construct($name , $tmp){
			$this->img = $this->openImage($name , $tmp);
			$this->width = imagesx($this->img);
			$this->height = imagesy($this->img);
		}
		
		function openImage($name , $tmp){
			$ext = strtolower(strchr($name,'.'));
			switch($ext){
				case '.jpg':
				case '.jpeg':
					$img = @imagecreatefromjpeg($tmp);
					break;
				case '.gif':
					$img = @imagecreatefromgif($tmp);
					break;
				case '.png':
					$img = @imagecreatefrompng($tmp);
					break;
				default:
					$img = false;
					break;
			}
			return $img;
		}
		
		function resizeImage($newWidth , $newHeight , $opt = "auto"){
			$optArr = $this->getDimession($newWidth , $newHeight , $opt);
			$optWidth = $optArr['optimalWidth'];
			$optHeight = $optArr['optimalHeight'];
			$this->imgResize = imagecreatetruecolor($optWidth , $optHeight);
			imagecopyresampled($this->imgResize , $this->img , 0 , 0 , 0 , 0 , $optWidth , $optHeight , $this->width , $this->height);
			
			if ($opt == "crop"){
				$this->crop($optWidth , $optHeight , $newWidth , $newHeight);
			}
		}
		
		function getDimession($newWidth , $newHeight , $opt){
			switch($opt){
				case 'exact':
					$optWidth = $newWidth;
					$optHeight = $newHeight;
					break;
				case 'portrait':
					$optWidth = $this->getSizeByFixedHeight($newHeight);
					$optHeight = $newHeight;
					break;
				case 'landscape':
					$optWidth = $newWidth;
					$optHeight = $this->getSizeByFixedWidth($newWidth);
					break;
				case 'auto':
					$optArr = $this->getSizeByAuto($newWidth , $newHeight);
					$optWidth = $optArr['optimalWidth'];
					$optHeight = $optArr['optimalHeight'];
					break;
				case 'crop':
					$optArr = $this->getOptimalCrop($newWidth , $newHeight);
					$optWidth = $optArr['optimalWidth'];
					$optHeight = $optArr['optimalHeight'];
					break;
			}
			
			return array(
				'optimalWidth' => $optWidth,
				'optimalHeight' => $optHeight
			);
			
		}
		
		
		function getSizeByFixedHeight($newHeight){
			$ratio = $this->width / $this->height;
			$newWidth = $newHeight * $ratio;
			return $newWidth;
		}
		
		function getSizeByFixedWidth($newWidth){
			$ratio = $this->height / $this->width;
			$newHeight = $newWidth * $ratio;
			return $newHeight;
		}
		
		function getSizeByAuto($newWidth , $newHeight){
			
			if ($this->width > 410){
			
			if ($this->height < $this->width){
				$optimalWidth = $newWidth;
				$optimalHeight = $this->getSizeByFixedWidth($newWidth);
			}else if ($this->height > $this->width){
				$optimalWidth = $this->getSizeByFixedHeight($newHeight);
				$optimalHeight = $newHeight;
			}else{
				if ($newHeight < $newWidth){
					$optimalWidth = $newWidth;
					$optimalHeight = $this->getSizeByFixedWidth($newWidth);
				}else if ($newHeight > $newWidth){
					$optimalWidth = $this->getSizeByFixedHeight($newHeight);
					$optimalHeight = $newHeight;
				}else{
					$optimalWidth = $newWidth;
					$optimalHeight = $newHeight;
				}
			}
			
			}else{
				
				$optimalWidth = $this->width;
				$optimalHeight = $this->height;
				
			}
			
			return array(
				'optimalWidth' => $optimalWidth,
				'optimalHeight' => $optimalHeight
			);
			
		}
		
		function getOptimalCrop($newWidth , $newHeight){
			$heightRatio = $this->height / $newHeight;
			$widthRatio = $this->width / $newWidth;
			
			if ($heightRatio < $widthRatio){
				$optimalRatio = $heightRatio;
			}else{
				$optimalRatio = $widthRatio;
			}
			
			$optimalHeight = $this->height / $optimalRatio;
			$optimalWidth = $this->width / $optimalRatio;
			
			return array(
				'optimalWidth' => $optimalWidth,
				'optimalHeight' => $optimalHeight
			);
			
		}
		
		
		function crop($optWidth , $optHeight , $newWidth , $newHeight){
			
			$cropStartX = ($optWidth / 2) - ($newWidth / 2);
			$cropStartY = ($optHeight / 2) - ($newHeight / 2);
			
			$crop = $this->imgResize;
			
			$this->imgResize = imagecreatetruecolor($newWidth , $newHeight);
			
			imagecopyresampled($this->imgResize , $crop , 0 , 0 ,$cropStartX , $cropStartY , $newWidth , $newHeight ,$newWidth , $newHeight );
			
		}
		
		function saveImage($savePath , $imgQuality = "100"){
			$ext = strchr($savePath , '.');
			$ext = strtolower($ext);
			switch($ext){
				case '.jpg':
				case '.jpeg':
					if (imagetypes() & IMG_JPG){
						imagejpeg($this->imgResize,$savePath,$imgQuality);
					}
					break;
				case '.gif':
					if (imagetypes() & IMG_GIF){
						imagegif($this->imgResize,$savePath);
					}
					break;
				case '.png':
					$scaleQuality = round(($imgQuality / 100) * 9);
					$invert = 9 - $scaleQuality;
					if (imagetypes() & IMG_PNG){
						imagepng($this->imgResize,$savePath,$invert);
					}
					break;
				default:
					break;
			}
			
			imagedestroy($this->imgResize);
			
		}
		
		
		
	}
	
?>