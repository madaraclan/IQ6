<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');

Import::Model('Account.User');
Import::Model('Account.Userstatus');
Import::Model('Account.Userfriend');

class _Friends extends Controller {
    private $userModel;
    
    public function __construct(URI $URI, Input $Input) {
        $this->userModel = new User();
        $this->userModel->ValidateLogin($Input)->ValidateLoginStatus('Activated', $Input);
    }

    public function MainLoad(URI $URI, Input $Input) {
        $UName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
        $this->Friends($UName, $Input);
        //echo 'BB';
    }

	function SearchFriendsLoad(URI $URI, Input $Input){
		$Keywords = $Input->Post('Keywords');
		 $ResultFriends = $this->userModel->GetUserFriends($Input, $Keywords);
		 
		 echo json_encode(array(
		 	'status' => 1,
		 	'result' => $ResultFriends
		 ));
		 
	}

    private function Friends($UName, $Input) {
    	
        $user = $this->userModel->GetUserProfile($UName);
	
        if ($user === FALSE) {
            redirect(Config::Instance(SETTING_USE)->baseUrl.'Error404');
            return false;
        }

        $followers  = $this->userModel->GetUserFollower($UName);
        $followings = $this->userModel->GetUserFollowing($UName);

        $userStatus = new Userstatus();
        $posts      = $userStatus->GetUserDetailPosts($UName, $Input);
                
    	Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
    	
    	$friend = new Userfriend();
    	$ButtonTeman = '';
        
    	 if ($UName != $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
        
    	$DataFollow = $friend->CekFollowFriend($Input, $UName);
    		$DataFollow_Type = 'Follow';
    		$DataFollow_TypeClass = 'buttonOrange';
    		if ($DataFollow){
    			$DataFollow_Type = 'Un Follow';
    			$DataFollow_TypeClass = 'buttonGray';
    		}
    		
    		$ButtonTeman = '
    				<div class="buttonContainer">
                        <span class="'.$DataFollow_TypeClass.'"><input data-UName="'.$UName.'" data-AliasingName="'.$user->AliasingName.'" type="button" name="follow" id="follow" value="'.$DataFollow_Type.'" class="button" /></span>
                    </div>
    		';
    		
        } 
       
        Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        
        $UserSignIn = new User();
        $DataFriendsDefault = $UserSignIn->GetUserFriends($Input);
    	
        //echo '<pre>';
    	//print_r($DataFriendsDefault);
    	//echo '</pre>';
       
        
        Database::Instance()->SetConfig("localhost", "mastertables");
        Database::Instance()->Connect();
        
        $dataFriend = json_decode($friend->PictureFriendTag($Input));
        
        Import::Template($user->FirstName.' '.$user->LastName);
        Import::View('Friends', array(
       	 	'SourceTagPicture' => $dataFriend->picture,
        	'SourceTagUName' => $dataFriend->uname,
        	'SourceTagfullname' => $dataFriend->fullname,
        	'SourceTagAddtional' => $dataFriend->addtional,
                                    'user'          =>$user,
                                    'followers'     =>$followers,
                                    'followings'    =>$followings,
                                    'posts'         =>$posts,
        'UName' => $UName,
        'ButtonTeman' => $ButtonTeman,
        'UNameCurrent' => $Input->Session('EDU')->GetValue('EDU_TOKENUNAME'),
        'FriendsDefault' => $DataFriendsDefault
        ));
    }
}
