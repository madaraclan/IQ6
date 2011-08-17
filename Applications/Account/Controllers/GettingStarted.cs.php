<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');

Import::Model('Account.User');

class _GettingStarted extends Controller {

    public function __construct(URI $URI, Input $Input) {
        $User = new User();
        $User->ValidateLogin($Input)->ValidateLoginStatus('New', $Input);
    }
	
    public function MainLoad(URI $URI, Input $Input) {
    	
    	
    	Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        
        // Sign in
    	$UserSignIn = new User();
    	//$UserSignIn->SignIn($Input);
    	
    	//echo $Input->Session('EDU')->GetValue('EDU_TOKENID');
    	
    	Database::Instance()->SetConfig("localhost", "mastertables");
        Database::Instance()->Connect();
    	
    	$DataUser = ($UserSignIn->GetBasicInformation($Input));
    	
    	Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
    	
    	$Musics = new Usermusic();
    	$DataUser->Musics = $Musics->GetDataMusics($Input->Session('EDU')->GetValue('EDU_TOKENID'));
    	
    	$Books = new Userbooks();
    	$DataUser->Books = $Books->GetDataBooks($Input->Session('EDU')->GetValue('EDU_TOKENID'));
    	
    	$Movies = new Usermovies();
    	$DataUser->Movies = $Movies->GetDataMovies($Input->Session('EDU')->GetValue('EDU_TOKENID'));
    	
    	$Hobby = new Userhobby();
    	$DataUser->Hobby = $Hobby->GetDataHobby($Input->Session('EDU')->GetValue('EDU_TOKENID'));
    	
    	$Phone = new Userphone();
    	$DataUserPhone = $Phone->GetDataUserphone($Input->Session('EDU')->GetValue('EDU_TOKENID'));
    	
    	$Relation = new Userrelationship();
    	$DataRelation = $Relation->GetDataRelation($Input->Session('EDU')->GetValue('EDU_TOKENUNAME'));
    	
    	$_MusicsJS = '';
    	$_Musics = '';
    	for($i=count($DataUser->Musics); $i>0; $i--){
    		$_Musics .= '<li>'.$DataUser->Musics[$i-1]->UMNameMusic.' <a href="#" data-Value="'.$DataUser->Musics[$i-1]->UMNameMusic.'" class="RemoveListMusic"></a></li>';
    		$_MusicsJS .= 'ArrMusic.push("'.$DataUser->Musics[$i-1]->UMNameMusic.'");';
    	}
    	
    	$_BooksJS = '';
    	$_Books = '';
    	for($i=count($DataUser->Books); $i>0; $i--){
    		$_Books .= '<li>'.$DataUser->Books[$i-1]->UBNameBook.' <a href="#" data-Value="'.$DataUser->Books[$i-1]->UBNameBook.'" class="RemoveListMusic"></a></li>';
    		$_BooksJS .= 'ArrBooks.push("'.$DataUser->Books[$i-1]->UBNameBook.'");';
    	}
    	
    	$_MoviesJS = '';
    	$_Movies = '';
    	for($i=count($DataUser->Movies); $i>0; $i--){
    		$_Movies .= '<li>'.$DataUser->Movies[$i-1]->UMVNameMovie.' <a href="#" data-Value="'.$DataUser->Movies[$i-1]->UMVNameMovie.'" class="RemoveListMusic"></a></li>';
    		$_MoviesJS .= 'ArrMovie.push("'.$DataUser->Movies[$i-1]->UMVNameMovie.'");';
    	}
    	
   	 	$_HobbyJS = '';
    	$_Hobby = '';
    	for($i=count($DataUser->Hobby); $i>0; $i--){
    		$_Hobby .= '<li>'.$DataUser->Hobby[$i-1]->UHHobby.' <a href="#" data-Value="'.$DataUser->Hobby[$i-1]->UHHobby.'" class="RemoveListMusic"></a></li>';
    		$_HobbyJS .= 'ArrHobby.push("'.$DataUser->Hobby[$i-1]->UHHobby.'");';
    	}
    	
    	$_PhoneJS = '';
    	$_Phone = '';
    	$TypePhone = '';
    	for($i=count($DataUserPhone); $i>0; $i--){
    		if ($DataUserPhone[$i-1]->UTPID == 1) $TypePhone = 'Work';
    		if ($DataUserPhone[$i-1]->UTPID == 2) $TypePhone = 'Home';
    		if ($DataUserPhone[$i-1]->UTPID == 3) $TypePhone = 'Mobile';
    		$_Phone .= '<li>'.$TypePhone.' - '.$DataUserPhone[$i-1]->UPPhone.' <a href="#" data-Value="'.$DataUserPhone[$i-1]->UPPhone.'" class="RemoveListMusic"></a></li>';
    		$_PhoneJS .= '
    		ArrPhone.push({
    			Type : "'.$DataUserPhone[$i-1]->UTPID.'",
    			Phone : "'.$DataUserPhone[$i-1]->UPPhone.'"
    		});
    		';
    	}
    	
    	//echo '<pre>';
    	//print_r($DataUser);
    	//echo '</pre>';
    	
        Import::Template('Getting Started');
        Import::View('GettingStarted/Profile', array(
        	'FirstName' => $DataUser->FirstName,
        	'LastName' => $DataUser->LastName,
        	'AliasingName' => $DataUser->AliasingName,
        	'UName' => $DataUser->UName,
        	'Gender' => $DataUser->Gender,
        	'Nationality' => ($DataUser->Nationality ? $DataUser->Nationality[0] : ''),
        	'CurrentCity' => ($DataUser->CurrentCity ? $DataUser->CurrentCity[0] : ''),
        	'Hometown' => ($DataUser->Hometown ? $DataUser->Hometown[0] : ''),
        	'Email' => $DataUser->Email,
        	'Religion' => $DataUser->Religion,
        	'Interest' => $DataUser->Interest,
        	'Birthday' => $DataUser->Birthday,
        	'ShowBirthday' => $DataUser->ShowBirthday,
        	'AboutMe' => $DataUser->AboutMe,
        	'EmployersAt' => $DataUser->EmployersAt,
        	'Musics' => $_Musics,
        	'Books' => $_Books,
        	'Movies' => $_Movies,
        	'_MusicsJS' => $_MusicsJS,
        	'_BooksJS' => $_BooksJS,
        	'_MoviesJS' => $_MoviesJS,
        	'Hobby' => $_Hobby,
        	'_HobbyJS' => $_HobbyJS,
        	'Email' => $DataUser->Email,
        	'Address' => $DataUser->Address,
        	'Phone' => $_Phone,
        	'_PhoneJS' => $_PhoneJS,
        	'RelationType' => ($DataRelation ? $DataRelation[0]->RID : ''),
        	'RelationURToUName' => ($DataRelation ? $DataRelation[0]->URToUName : ''),
        	'RelationURToUName_FirstName' => ($DataRelation ? $DataRelation[0]->FirstName : ''),
        	'RelationURToUName_LastName' => ($DataRelation ? $DataRelation[0]->LastName : ''),
        ));
    }

    public function ProfilePictureLoad(URI $URI, Input $Input) {
    	
    	Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        
    	$UserSignIn = new User();
    	
    	Database::Instance()->SetConfig("localhost", "mastertables");
        Database::Instance()->Connect();
    	
        $TokenId = $Input->Session('EDU')->GetValue('EDU_TOKENID');
        
    	$DataUser = ($UserSignIn->GetBasicInformation($Input));
    	
    	//echo '<pre>';
    	//print_r($DataUser);
    	//echo '</pre>';
    	
    	$AvatarFilePath = $DataUser->AvatarFilePath;
    	if (!$AvatarFilePath) $AvatarFilePath = '';
    	
        Import::Template('Getting Started');
        Import::View('GettingStarted/ProfilePicture', array(
        	'Avatar' => $AvatarFilePath,
     		'TokenId' => $TokenId
        ));
    }
    
    public function FindFriendsLoad(URI $URI, Input $Input) {
    	
    	Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        
        $UserSignIn = new User();
        $DataFriendsDefault = json_decode($UserSignIn->GetUserFindFriends($Input));
    	
        //echo '<pre>';
    	//print_r($DataFriendsDefault);
    	//echo '</pre>';
        
    	Import::Template('Getting Started');
        Import::View('GettingStarted/FindFriends', array(
        	'FriendsDefault' => $DataFriendsDefault->message
        ));
        
    }

    public function FinishLoad(URI $URI, Input $Input) {
        Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        
        $user = new User();
        $user->ChangeStatus('Activated', $Input);

        redirect($URI->ReturnURI('App=Account&Com=NewsFeeds'));
    }
    
}
