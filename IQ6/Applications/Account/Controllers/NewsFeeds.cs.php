<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');

Import::Model('Account.User');
Import::Model('Account.Userfriend');
Import::Model('Account.Userstatus');

Import::Model('Account.Usermessage');

class _NewsFeeds extends Controller {

    public function __construct(URI $URI, Input $Input) {
        $user = new User();
        $user->ValidateLogin($Input)->ValidateLoginStatus('Activated', $Input);
    }

    public function MainLoad(URI $URI, Input $Input) {
        
        
    	
    	Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        
        // Sign in
    	//$UserSignIn = new User();
    	//$UserSignIn->SignIn($Input);
        
        $friend = new Userfriend();
        
    	$UserSignIn = new User();
    	
    	$Following = $friend->following($Input);
    	
    	$CountFollowing = $friend->CountFollowing;
    	
    	$Followers = $friend->followers($Input);
    	
    	$CountFollowers = $friend->CountFollowers;
    	
    	//print_r($Following);
    	
    	
    	Database::Instance()->SetConfig("localhost", "mastertables");
        Database::Instance()->Connect();
        
        $dataFriend = json_decode($friend->PictureFriendTag($Input));
        
        $DataUser = ($UserSignIn->GetBasicInformation($Input));
        
       // echo '<pre>';
       // print_r($dataFriend);
        //echo '</pre>';
        
        $AvatarFilePath = $DataUser->AvatarFilePath;
    	if (!$AvatarFilePath) $AvatarFilePath = '';
    	
    	if (!$AvatarFilePath && ! file_exists($AvatarFilePath)){
            $Avatar = '<img src="'.Path::Template('Images/thumb.jpg').'" />';
            $AvatarFilePath = '<img src="'.Path::Template('Images/thumb1.jpg').'" width="32" height="32" />';
    	}else{
    		$Avatar = '<img src="'.Config::Instance('default')->photos.'p_medium_'.$AvatarFilePath.'.jpg" />';
    		$AvatarFilePath = '<img src="'.Config::Instance('default')->photos.'p_small_'.$AvatarFilePath.'.jpg" width="32" height="32" />';
    	}
    	
    	/*
    	Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
    	$stmt = Database::Instance()->ExecuteQuery("
	       select * from
	       userstatusdetail
	       where
	       userstatusdetail.USID in (
	       select USID from userstatus 
	       join user on (
	       user.UName = userstatus.UName
	       )
	       where
	       userstatus.UName = '".$Input->Session('EDU')->GetValue('EDU_TOKENUNAME')."' or
	       User.UName in(
	       			SELECT UFRName FROM userfriend
	                WHERE UName = '".$Input->Session('EDU')->GetValue('EDU_TOKENUNAME')."' and
	                Muted = 0
	       )
	       )
	       order by userstatusdetail.USDID desc
	       limit 1
	        ");
    	
    	$result = Database::Instance()->Fetch($stmt);
    	echo '<pre>';
    	print_r($result[0]->USDID);
    	echo '</pre>';
    	*/
    	
    	Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
    	$stmt = Database::Instance()->ExecuteQuery("
    	select * from notificationcomment
    	where
    	NAuthor = '".$Input->Session('EDU')->GetValue('EDU_TOKENUNAME')."'
    	");
    		
    		$result = Database::Instance()->Fetch($stmt);
    	
    		$jmlnotif  = 0;
    		foreach($result as $res){
    			
	    		$ArrUName = $res->NArrUName;
	    		
	    		if ($ArrUName){
	    		$re = $ArrUName;
	    		$ea = explode(';', $re);
				$ea = array_map('trim', $ea);

				foreach($ea as $r){
					
					if ($r){
					
					$ea1 = explode('=', $r);
					$ea1 = array_map('trim', $ea1);
					$UN = $ea1[0];
					$VA = $ea1[1];
					if ($r 
					&& $UN == $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')
					&& $VA == 1){
						$jmlnotif++;
					}
					
					
					}
					
				}
				
	    		}
    			
    		}
    		//$userStatus = new Userstatus();
   			
    		//$NotifDetail = $userStatus->Notif($Input);
    		
    		//echo '<pre>';
    		//print_r($NotifDetail);
    		//echo '</pre>';
    		
    		$JmlMessage = new Usermessage();
    		$NoReadMessage = $JmlMessage->JmlReadMessage($DataUser->UName);
    		
        Import::Template('Home');
        Import::View('Wall', array(
        	'SourceTagPicture' => $dataFriend->picture,
        	'SourceTagUName' => $dataFriend->uname,
        	'SourceTagfullname' => $dataFriend->fullname,
        	'SourceTagAddtional' => $dataFriend->addtional,
        	'FirstName' => $DataUser->FirstName,
        	'LastName' => $DataUser->LastName,
        	'AliasingName' => $DataUser->AliasingName,
        	'UName' => $DataUser->UName,
        	'Gender' => $DataUser->Gender,
        	'Avatar' => $Avatar,
        	'Following' => $Following,
        	'CountFollowing' => $CountFollowing,
        	'Followers' => $Followers,
        	'CountFollowers' => $CountFollowers,
        	'AvatarFilePath' => $AvatarFilePath,
        	'JmlNotif' => $jmlnotif,
        	'JmlMessage' => $NoReadMessage
        ));
    }
}
