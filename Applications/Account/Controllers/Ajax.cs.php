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

class _Ajax extends Controller{
	
	public $TokenId;
	
	
	/*
	 * STATUS
	 */
	function DeleteStatusLoad(URI $URI, Input $Input){

		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
		
        $_UserStatus = new Userstatus();
        $_UserStatus->DeleteUserStatus($Input);
        
        /**
         * Database::Instance()->ExecuteQuery('
        	
        ');
         */
        
        //$IdStatus = $Input->Post('IdStatus');
        
        //Database::Instance()->ExecuteQuery("
        //delete from userstatus where USID = '.$IdStatus.'
        //");
                
        //Database::Instance()->ExecuteQuery("
        //delete from userstatusdetail where USID = '.$IdStatus.'
        //");
        
        
		echo json_encode(array('status' => 1));
		
	}
function ParsingURLLoad(URI $URI, Input $Input){
		//echo $Input->Post('url').$Input->Post('status');
		$_url = $Input->Post('url');
		
		//$ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $_url);
		//$ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $_url);
		
		if (preg_match("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", $_url) ||
		preg_match("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", $_url)){
		
		if (preg_match("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", $_url)) {
			$_url = 'http://'.$_url;
		}
			
		$html = file_get_html($_url);
		$title = '';
		$detail = '';
		$img = '';
		$url = $Input->Post('Html');
		foreach($html->find('title') as $e){
			$title = $e->plaintext;
		}
		foreach($html->find('meta[name=description]') as $e){
			$detail = $e->content;
		}
		if (!$detail){
		foreach($html->find('meta[name=Description]') as $e){
			$detail = $e->content;
		}
		}
		
		foreach($html->find('meta') as $e){
			$tempimg = $e->content;
			$jpeg = '.jpg';
			$pos = strpos($tempimg, $jpeg);
			if ($pos){
				$img = '<img src="'.$tempimg.'" />';
				break;
			}
			
			if (!$img){
				$png = '.png';
				$pos = strpos($tempimg, $png);
				if ($pos){
					$img = '<img src="'.$tempimg.'" />';
					break;
				}
			}
			
		}
		
		if (!$img){
		foreach($html->find('img') as $e){
			$tempimg = $e->outertext;
			$jpeg = '.jpg';
			$pos = strpos($tempimg, $jpeg);
			if ($pos){
				$img = $tempimg;
				break;
			}
		}
		}
		
		$service = '';$formopen = '';$formclose = '</a>';
		if (preg_match('/^http\:\/\/www\.youtube\.com/',$_url) || 
			preg_match('/^http\:\/\/youtu.be\//',$_url) || 
			preg_match('/^http\:\/\/youtube\.com/',$_url)){
			$service = "youtube";
			$formopen = '<a href="'.$_url.'" class="embedmedia" id="embedmedia" rel="'.$service.'">';
		}else if (preg_match('/^http\:\/\/vimeo\.com/',$_url)){
			$service = "vimeo";
			$formopen = '<a href="'.$_url.'" class="embedmedia" id="embedmedia" rel="'.$service.'">';
		}else{
			$service = "link";
			$formopen = '<a href="'.$_url.'" target="blank" class="link" id="link" rel="'.$service.'">';
		}
		
		$p = parse_url($_url, PHP_URL_HOST);
		
		echo json_encode(array(
			'status' => 1,
			'title' => '<a href="'.$_url.'" target="_blank"><b>'.$title.'</b></a><div><a href="http://'.$p.'" target="_blank">'.$p.'</a></div>',
			'detail' => '<p>'.$detail.'</p>',
			'img' => $formopen.$img.$formclose,
			'url' => '<a href="'.$url.'">'.$url.'</a>'
		));
		
		}else{
			
			echo json_encode(array('status' => 0));
			
		}
		
	}
function RealTimeGetStatusLoad(URI $URI, Input $Input){
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
	
        $ShareStatus = new Userstatus();
        $ResponseStatus = $ShareStatus->RealTimeGetStatus($Input, $Input->Post('LastId'));
		
        echo $ResponseStatus;
	}
	
	function RealTimeGetTimeLoad(URI $URI, Input $Input){
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
	
        $ShareStatus = new Userstatus();
        $ResponseStatus = $ShareStatus->RealTimeGetTime($Input);
		
        echo $ResponseStatus;
	}
function LikesStatusLoad(URI $URI, Input $Input){
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        $Userstatuslikes = new Userstatuslikes();
        $DataUserLike = $Userstatuslikes->LikeStatus($Input);
        echo $DataUserLike;
	}
function UpdateStatusLoad(URI $URI, Input $Input){
		
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
	
        $ShareStatus = new Userstatus();
        $ResponseStatus = $ShareStatus->ShareStatus($Input);
		
        echo $ResponseStatus;
        
	}
function GetStatusLoad(URI $URI, Input $Input){
		
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
	
        $ShareStatus = new Userstatus();
        $ResponseStatus = $ShareStatus->GetStatus($Input, $Input->Post('start'));
		
        echo $ResponseStatus;
        
	}
	/*
	 * END STATUS
	 */
	
	
	/*
	 * COMMENT
	 */
	
function DeleteCommentLoad(URI $URI, Input $Input){

		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
		
        $_UserStatusDetail = new Userstatusdetail();
        $_UserStatusDetail->DeleteComment_WithOutParent($Input);
        
        //$IdComment = $Input->Post('IdStatus');
        
        //Database::Instance()->ExecuteQuery("
        //delete from userstatusdetail where USDID = '.$IdComment.'
        //");
        
		echo json_encode(array('status' => 1));
		
	}
	
	function CommentContainerLoad(URI $URI, Input $Input){
		
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        
        // Sign in
    	$UserSignIn = new User();
    	
    	Database::Instance()->SetConfig("localhost", "mastertables");
        Database::Instance()->Connect();
    	
    	$DataUser = ($UserSignIn->GetBasicInformation($Input));
    	
    	$AvatarFilePath = ($DataUser->AvatarFilePath)
                          ? 'p_small_'.$DataUser->AvatarFilePath.'.jpg' : 'thumb1.jpg';
    	//if (!$AvatarFilePath) $AvatarFilePath = '';
		
                          /*
		echo '<li id="'.$Input->Post('StatusId').'" class="CommentContainer">
	             	<span class="profilePicture">
	             		<img src="'.Config::Instance(SETTING_USE)->photos.$AvatarFilePath.'" width="32" height="32" />
	                </span>
	
	                <span class="commentInfo">
	                	<form id="CommentUpload" name="CommentUpload" method="post">
	                    	<input type="hidden" id="StatusId" name="StatusId" value="'.$Input->Post('StatusId').'" /> 	
	                		<textarea id="commentStatus" class="ShareStatus" name="commentStatus" style="height:10px;width:385px;">Write a comment...</textarea>
	                	</form>
	                </span>
	         </li>';
	         */
		
		Import::View('ajax/CommentContainer', array(
			'StatusId' => $Input->Post('StatusId'),
			'Avatar' => Config::Instance(SETTING_USE)->photos.$AvatarFilePath
		));
	
	}
	
	
	
	function LikesStatusCommentLoad(URI $URI, Input $Input){
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        $Userstatuslikes = new Userstatusdetaillike();
        $DataUserLike = $Userstatuslikes->LikeStatus($Input);
        echo $DataUserLike;
	}
	
	
	
	function UpdateCommentLoad(URI $URI, Input $Input){
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
	
        $ShareStatus = new Userstatusdetail();
        $ResponseStatus = $ShareStatus->ShareStatus($Input);
        
        //echo $Input->Post('Status', false);
        
        echo $ResponseStatus;
	}
	
	
	/*
	 * END COMMENT
	 */
	
	
	
	
	
	/*
	 * FREIENDS
	 */
	
function MutedFriendLoad(URI $URI, Input $Input){
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        $UserFriend = new Userfriend();
        $UserFriend->MutedFriend($Input);
        echo json_encode(array('status' => 1));
	}
	
	
function FollowFriendLoad(URI $URI, Input $Input){
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        $Friend = new Userfriend();
        $Friend->FollowFriend($Input);
        echo json_encode(array(
        	'status' => 1
        ));
	}
	
	function UnFollowFriendLoad(URI $URI, Input $Input){
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        $Friend = new Userfriend();
        $Friend->UnFollowFriend($Input);
        echo json_encode(array(
        	'status' => 1
        ));
	}
	
	function SearchFriendLoad(URI $URI, Input $Input){
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        
			$FirstName = $Input->Post('HiddenFirstName');
			$LastName = $Input->Post('HiddenLastName');
			$Name = $Input->Post('peopleName');
			$CurrentCity = $Input->Post('currentCity_Input');
			$CurrentHometown = $Input->Post('homeTown_Input');
			$Gender = $Input->Post('gender');
			$Relation = $Input->Post('relationshipStatus');
			$interestedIn = $Input->Post('interestedIn');
			$return_interestedIn = '';
	    	for($i = 0; $i<count($interestedIn); $i++){
	    		$return_interestedIn .= $interestedIn[$i];
	    		if ($i != count($interestedIn) - 1) $return_interestedIn .= ', ';
	    	}
	    	
	    	$sql = array();
	    	if ($FirstName && $LastName){
	    		$sql[] = ' (
	        user.FirstName like "%'.$FirstName.'%" or
	        user.LastName like "%'.$LastName.'%"
	        )';
	    	}else if ($Name != 'Type Name of People'){
	    		$sql[] = ' (
	        user.FirstName like "%'.$Name.'%" or
	        user.LastName like "%'.$Name.'%"
	        )';
	    	}
	    	
	    	if ($CurrentCity){
	    		$sql[] = '(
	        user.CurrentCity = '.$CurrentCity.'
	        )';
	    	}
	    	
	    	if ($CurrentHometown){
	    		$sql[] = '(
	        user.Hometown = '.$CurrentHometown.'
	        )';
	    	}
	    	
	    	if ($Gender){
	    		$sql[] = '(
	        user.Gender = "'.$Gender.'"
	        )';
	    	}
	    	
	    	if ($Relation){
	    		$sql[] = '(
	    		c.RName = "'.$Relation.'"
	    		)';
	    	}
	    	
	    	if ($interestedIn){
	    		$sql[] = '(
	        user.Interest like "%'.$return_interestedIn.'%"
	        )';
	    	}
	    	
	    	$sql = join(' and ', $sql);
	    	//echo $sql;
	    	
	    	
	    	if ($sql){
        $stmt = Database::Instance()->ExecuteQuery("
	        select
	        user.*,
	        c.RName
	        from
	        user
	        left join userrelationship b on(
	        b.URUName = user.UName
	        )
	        left join relationship c on(
	        c.RID = b.RID
	        )
	        where
	        ".$sql."
	    ");
        $datas = Database::Instance()->Fetch($stmt);
        $Friend = new User();
       	$DataFriend = $Friend->GetUserFindFriends($Input, $datas);
       	
        echo $DataFriend;
        
	    	}else{
	    		
	    		echo json_encode(array(
	    			'status' => 0,
	    			'message' => 'Not Found'
	    		));
	    		
	    	}
        
	}
	
	
	/*
	 * END FRIEND
	 */
	
	
	
	
	
	
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
	
	function GetCurrentUserLoad(URI $URI, Input $Input){
	
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
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

?>