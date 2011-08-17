<?php

if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');

Import::Model('Account.User');
Import::Model('Account.Userstatus');
Import::Model('Account.Userfriend');

class _EditProfilePicture extends Controller {
	
	private $userModel;
	
	public function __construct(URI $URI, Input $Input) {
        $this->userModel = new User();
        $this->userModel->ValidateLogin($Input)->ValidateLoginStatus('Activated', $Input);
    }
    
	public function MainLoad(URI $URI, Input $Input) {
		$UName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
        $this->EditProfilePictureUser($UName, $Input);
    }
    
	public function EditProfilePictureUser($UName, $Input) {
    	
    	Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        
    	$UserSignIn = new User();
    	
    	Database::Instance()->SetConfig("localhost", "mastertables");
        Database::Instance()->Connect();
    	
        $TokenId = $Input->Session('EDU')->GetValue('EDU_TOKENID');
        
    	$DataUser = ($UserSignIn->GetBasicInformation($Input));
    	
    	$AvatarFilePath = $DataUser->AvatarFilePath;
    	if (!$AvatarFilePath) $AvatarFilePath = '';
    	
    	Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
    	
		$user = $this->userModel->GetUserProfile($UName);
	
        if ($user === FALSE) {
            redirect(Config::Instance(SETTING_USE)->baseUrl.'Error404');
            return false;
        }
    	
    	$UName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
        Import::Template($user->FirstName.' '.$user->LastName);
        Import::View('EditProfilePicture', array(
        	'user' => $user,
        	'Avatar' => $AvatarFilePath,
     		'TokenId' => $TokenId
        ));
    	
    }
    
}
    
?>