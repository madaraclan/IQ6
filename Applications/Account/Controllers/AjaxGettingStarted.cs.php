<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');

Import::Model('Account.City');
Import::Model('Account.User');
Import::Model('Account.Userfriend');
Import::Model('Account.Userstatus');
Import::Model('Account.Userstatusdetail');
Import::Model('Account.Userstatuslikes');
Import::Model('Account.Userstatusdetaillike');
Import::Library('Plugin.Parsingresizeimage');
Import::Library('Plugin.ImageGD');
Import::Library('Plugin.simple_html_dom');

class _AjaxGettingStarted extends Controller{
	
	public $TokenId;

	/*
	 * GETTING STARTED
	 */
	
	
	
	
	
	
	function GetCurrentLocationLoad(URI $URI, Input $Input){
	
		Database::Instance()->SetConfig("localhost", "mastertables");
        Database::Instance()->Connect();
		$city = new City();
		$ListCity = $city->GetCity($Input);
		
		echo $ListCity;
		
	}
	
	function GetClickCurrentUserLoad(URI $URI, Input $Input){
		$Input->Session('EDU')->SetValue('Search_Token', $Input->Post('InputCurrentUser'));
		echo json_encode(array('status' => 1));
	}
	
	function GetCurrentUserLoad(URI $URI, Input $Input){
	
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        
        $Input->Session('EDU')->SetValue('Search_Token', $Input->Post('InputCurrentUser'));
        
		$user = new User();
		$ListUser = $user->GetUser($Input);
		
		echo $ListUser;
		
	}
	
	function UpdateBasicInformationLoad(URI $URI, Input $Input){
		
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        $user = new User();
        $SaveUser = $user->SaveBasicInformation($Input);
		
        echo $SaveUser;
        
	}
	
	function UpdateEmployeLoad(URI $URI, Input $Input){
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        $user = new User();
        $SaveUser = $user->SaveEmploye($Input);
		
        echo $SaveUser;
	}
	
	function UpdateEntertaimentLoad(URI $URI, Input $Input){
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        $user = new User();
        $SaveUser = $user->SaveEntertaiment($Input);
		
        echo $SaveUser;
	}
	
	function UpdateInterestLoad(URI $URI, Input $Input){
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        $user = new User();
        $SaveUser = $user->SaveInterest($Input);
		
        echo $SaveUser;
	}
	
	function UpdateContactInformationLoad(URI $URI, Input $Input){
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        $user = new User();
        $SaveUser = $user->SaveUpdateContactInformation($Input);
		
        echo $SaveUser;
	}
	
	function SavePhotoViaUploadLoad(URI $URI, Input $Input){
		//session_start();
		if (!empty($_FILES)) {

			$filename = md5($_SERVER['REMOTE_ADDR'].rand());
			
			$tempFile = $_FILES['Filedata']['tmp_name'];
			
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
			$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
			
			$nameGambar = $_FILES['Filedata']['name'];
			$tmpGambar = $_FILES['Filedata']['tmp_name'];
			
			$parsingresizeimage = new Parsingresizeimage();
			$gallery_path = 'Photos/';
			$__image_ThumbImage = $parsingresizeimage->save_image($nameGambar, $tmpGambar, 212, 174, 'crop', $gallery_path, 'p_big_'.$filename.'.jpg');
			$gallery_path = 'Photos/';
			$__image_ThumbImage = $parsingresizeimage->save_image($nameGambar, $tmpGambar, 80, 80, 'crop', $gallery_path, 'p_medium_'.$filename.'.jpg');
			$gallery_path = 'Photos/';
			$__image_ThumbImage = $parsingresizeimage->save_image($nameGambar, $tmpGambar, 48, 48, 'crop', $gallery_path, 'p_small_'.$filename.'.jpg');
			
			Database::Instance()->SetConfig("localhost", "socialnetwork");
        	Database::Instance()->Connect();
			$user = new User();
			$TokenId = $URI->GetURI(3);
			$user->UpdateAvatar($filename, $TokenId);
			
			$__image_ThumbImage = 'p_big_'.$filename.'.jpg';
			
			$targetFile = str_replace('//','//',$targetPath) . $__image_ThumbImage;
			
			echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
			
		}
	}
	
	function SavePhotoViaWebCamLoad(URI $URI, Input $Input){
		
			if (strtolower($_SERVER['REQUEST_METHOD']) != 'post'){
				exit;
			}
			$folder = 'Photos/';
			$filename = md5($_SERVER['REMOTE_ADDR'].rand());
			$original = $folder.$filename.'.jpg';
			$input = file_get_contents('php://input');
			if (md5($input) == '7d4df9cc423720b7f1f3d672b89362be'){
				exit;
			}
					
			$result = file_put_contents($original, $input);
			if (!$result){
				echo '{
					"error" : 1,
					"message" : "Gagal Save Image."
				}';
				exit;
			}
			
			$info = getimagesize($original);
			if ($info['mime'] != 'image/jpeg'){
				unlink($original);
				exit;
			}
			
			rename($original, 'Photos/p_big_' . $filename.'.jpg');
			
			// 128
			$original = 'Photos/p_big_'.$filename.'.jpg';
			$imageDestination  = Path::Root($original);
        
	        //if (file_exists($imageDestination)) unlink($imageDestination);
	        
	        $imageSource    = array(
	            "name" => Config::Instance('default')->photos.'p_big_'.$filename.'.jpg',
	            "type" => "image/jpeg"
	        );
	        $image  = new ImageGD($imageSource, 212, 174);
	
	        $prepare = $image->Prepare();
	
	        if ($image->Prepare() === TRUE) {
	            $image->Save($imageDestination);
	        }
	        
	        // 80
	        $original = 'Photos/p_medium_' . $filename . '.jpg';
			$imageDestination  = Path::Root($original);
        
	        //if (file_exists($imageDestination)) unlink($imageDestination);
	        
	        $imageSource    = array(
	            "name" => Config::Instance('default')->photos.'p_big_'.$filename . '.jpg',
	            "type" => "image/jpeg"
	        );
	        $image  = new ImageGD($imageSource, 80, 80);
	
	        $prepare = $image->Prepare();
	
	        if ($image->Prepare() === TRUE) {
	            $image->Save($imageDestination);
	        }
	        
			// 24
	        $original = 'Photos/p_small_' . $filename . '.jpg';
			$imageDestination  = Path::Root($original);
        
	        //if (file_exists($imageDestination)) unlink($imageDestination);
	        
	        $imageSource    = array(
	            "name" => Config::Instance('default')->photos.'p_big_'.$filename.'.jpg',
	            "type" => "image/jpeg"
	        );
	        $image  = new ImageGD($imageSource, 48, 48);
	
	        $prepare = $image->Prepare();
	
	        if ($image->Prepare() === TRUE) {
	            $image->Save($imageDestination);
	        }
			
			
			//- ------------------
			
	        /*
			$origImage = imagecreatefromjpeg($original);
			$newImage = imagecreatetruecolor(128, 128);
			imagecopyresampled($newImage, $origImage, 0, 0, 0, 0, 128, 128, 300, 400);
			imagejpeg($newImage, 'Photos/big/' . $filename);
			*/
		
	        Database::Instance()->SetConfig("localhost", "socialnetwork");
       	 	Database::Instance()->Connect();
	        $user = new User();
			$user->UpdateAvatar($filename, $Input->Session('EDU')->GetValue('EDU_TOKENID'));
	        
			echo '{
				"status" : 1,
				"message" : "Success",
				"filename" : "'.Config::Instance('default')->photos.'p_big_'.$filename.'.jpg"
			}';
			
	}
	
	function SkipUploadPhotoLoad(URI $URI, Input $Input){
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
		$user = new User();
		$Callback = $user->DeleteAvatar($Input);
		echo $Callback;
	}
	
	
	/*
	 * END GETTING STARTED
	 */
	
}