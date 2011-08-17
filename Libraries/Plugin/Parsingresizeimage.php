<?php
	
Import::Library('Plugin.Resizeimage');

	class Parsingresizeimage{
		
		public $resizeimage;
		
		function Parsingresizeimage(){
			$this->resizeimage = new Resizeimage();
		}
		
		function getExt($str){
			$i=strrpos($str,".");
			if (!$i) return "";
			$j=strlen($str)-$i;
			$ext=substr($str,$i+1,$j);
			return $ext;
		}
		
		function save_image($name, $tmp, $width, $height, $type, $location , $name_image = ''){
			$this->resizeimage->__Resizeimage($name, $tmp);
			
			if ($name_image == ''){
			$token=md5(substr(md5($_SERVER['REMOTE_ADDR'].microtime().rand(1,100000)),0,6));
			$name_image = 'img'.$token.'.jpg';
			}
			
			$this->resizeimage->createresizeImage($width, $height, $type); //exact, portrait, landscape, auto, crop
	
			$this->resizeimage->saveImage($name_image, 100, $location);
			
			return $name_image;
		}
		
	}

?>