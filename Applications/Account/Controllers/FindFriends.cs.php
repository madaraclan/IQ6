<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');

Import::Model('Account.User');
Import::Model('Account.Userstatus');
Import::Model('Account.Userfriend');

class _FindFriends extends Controller {
    private $userModel;
    
    public function __construct(URI $URI, Input $Input) {
        $this->userModel = new User();
        $this->userModel->ValidateLogin($Input)->ValidateLoginStatus('Activated', $Input);
    }

    public function MainLoad(URI $URI, Input $Input) {
        $UName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
        $this->FindFriends($UName, $Input);
        //echo 'BB';
    }
    
	public function SearchLoad(URI $URI, Input $Input) {
        $UName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
        $this->SearchFindFriends($UName, $Input);
        //echo 'BB';
    }

	function SearchFriendsLoad(URI $URI, Input $Input){
		$Keywords = $Input->Post('Keywords');
		 $ResultFriends = $this->userModel->GetUserSearchFriends($Input, $Keywords);
		 
		 echo json_encode(array(
		 	'status' => 1,
		 	'result' => $ResultFriends
		 ));
		 
	}
    
    private function FindFriends($UName, $Input) {
    	
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
       	
        $Keywords = '';
        if ($Input->Session('EDU')->GetValue('Search_Token')){
        	$Keywords = $Input->Session('EDU')->GetValue('Search_Token');
        }
        
        $ResultFriends = $this->userModel->GetUserSearchFriends($Input, $Keywords);
        
        //echo '<pre>';
        //print_r($ResultFriends);
        //echo '</pre>';
        
        $Input->Session('EDU')->SetValue('Search_Token', '');
        
        Database::Instance()->SetConfig("localhost", "mastertables");
        Database::Instance()->Connect();
        
        $dataFriend = json_decode($friend->PictureFriendTag($Input));
        
        Import::Template($user->FirstName.' '.$user->LastName);
        Import::View('FindFriends', array(
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
        'ResultFriends' => $ResultFriends
        ));
    }
    
    
    
	private function SearchFindFriends($UName, $Input) {
    	
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
       	
        $Keywords = '';
        if ($Input->Session('EDU')->GetValue('Search_Token')){
        	$Keywords = $Input->Session('EDU')->GetValue('Search_Token');
        }
        
        $ResultFriends = $this->userModel->GetUserSearchFriends($Input, $Keywords);
        
        //echo '<pre>';
        //print_r($ResultFriends);
        //echo '</pre>';
        
        $Input->Session('EDU')->SetValue('Search_Token', '');
        
        Database::Instance()->SetConfig("localhost", "mastertables");
        Database::Instance()->Connect();
        
        $dataFriend = json_decode($friend->PictureFriendTag($Input));
        
        Import::Template($user->FirstName.' '.$user->LastName);
        Import::View('FindAdvFriends', array(
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
        'ResultFriends' => $ResultFriends
        ));
    }
    
}
