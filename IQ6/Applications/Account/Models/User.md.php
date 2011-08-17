<?php

Import::Entity('Account.User');
Import::Model('Account.Nationality');
Import::Model('Account.Country');
Import::Model('Account.City');
Import::Model('Account.Usermusic');
Import::Model('Account.Userbooks');
Import::Model('Account.Usermovies');
Import::Model('Account.Userhobby');
Import::Model('Account.Usertypephone');
Import::Model('Account.Userphone');
Import::Model('Account.Userrelationship');
Import::Model('Account.Userfriend');

class User extends Model{
	
	public function __construct() {
        parent::__construct('localhost', 'socialnetwork');
        $this->tableName = 'user';
        $this->lastTable = 'user';
        $this->application = 'Account';
    }
    
    function SignIn(Input $Input){
    	
    	$result = Database::Instance()->ExecuteQuery("
    	select * from user
    	where 
    	UName = '".$Input->Post('userID')."' and
    	UPass = '".md5($Input->Post('password'))."' and
    	IsActive = 'Y'
    	");
    	$result = Database::Instance()->Fetch($result);
    	
    	/*
        $result = $this->Equal('UName',$Input->Post('userID'))
                       ->Equal('UPass',md5($Input->Post('password')))
                       ->Equal('IsActive','Y')
                       ->Get();
        */
    	
        if ( ! empty($result)) {
            $result = $result[0];
			$arrLogin = (object) array(
				'UType' => $result->UType,
				'UName' => $result->UName
			); 
			$Input->Session('EDU')->SetValue('user', $arrLogin);
            $Input->Session('EDU')->SetValue('EDU_TOKENID', $result->AliasingName);
            $Input->Session('EDU')->SetValue('EDU_TOKENUNAME', $result->UName);
            $Input->Session('EDU')->SetValue('EDU_STATUS', $result->Status);
            return true;
        }
        return false;

    }
    
	function GetUser(Input $Input){
    	$User = $Input->Post('InputCurrentUser');
    	
    	$qUser = Database::Instance()->ExecuteQuery("
    	select * from user
    	where 
    	UName like '%".$User."%' or
    	FirstName like '%".$User."%' or
    	LastName like '%".$User."%' or
    	Email like '%".$User."%'
    	");
    	$qUser = Database::Instance()->Fetch($qUser);
    	
    	/*
    	$qUser = $this
    			->Like('UName', '%'.$User.'%', PDO::PARAM_STR, 'or')
    			->Like('FirstName', '%'.$User.'%', PDO::PARAM_STR, 'or')
    			->Like('LastName', '%'.$User.'%', PDO::PARAM_STR, 'or')
    			->Get();	
    	*/
    	
    	if ($qUser){
    		$return = '';
    	foreach($qUser as $item){
    		
    		$URL = URI::ReturnURI('App=Account&Com=Profile');
    		if ($item->UName !== $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
    		$URL = URI::ReturnURI('App=Account&Com=Profile&Act=Detail&UName='.Encryption::Encrypt($item->UName));
    		}
    		
    		Database::Instance()->SetConfig("localhost", "mastertables");
       	 	Database::Instance()->Connect();
    		$DataUser = $this->GetBasicInformation2($item->UName);
    		
    		$Gender = $DataUser->Gender;
        	$Nationality = ($DataUser->Nationality ? ' - '.$DataUser->Nationality[0]->NName : '');
        	$CurrentCity = ($DataUser->CurrentCity ? ' - '.$DataUser->CurrentCity[0]->CTName : '');
        	$Hometown = ($DataUser->Hometown ? ' - '.$DataUser->Hometown[0]->CTName : '');
    		
    		$img = '<img src="'.Config::Instance('default')->photos.'thumb1.jpg" style="float:left;margin-right:5px;" width="32" height="32" />';
    		if ($item->AvatarFilePath){
    			$img = '<img src="'.Config::Instance('default')->photos.'p_small_'.$item->AvatarFilePath.'.jpg" style="float:left;margin-right:5px;" width="32" height="32" />';
    		}
    		
    		if ($item->AliasingName != $Input->Session('EDU')->GetValue('EDU_TOKENID')){
    		$return .= '<li 
    		data-UName="'.$item->UName.'" data-UAliasingName="'.$item->AliasingName.'"
    		data-UFirstName="'.$item->FirstName.'"
    		data-ULastName="'.$item->LastName.'"
    		data-userlink="'.$URL.'"
    		style="overflow:hidden;"
    		>'.$img.'<div>'.$item->FirstName.' '.$item->LastName.'</div><div>'.$item->UName.' - '.$Gender.' '.$Nationality.' '.$Hometown.' '.$CurrentCity.'</div></li>';
    		
    		}
    	}
    		return json_encode(array(
    			'status' => 1,
    			'message' => $return
    		));
    	}else{
    		return json_encode(array(
    			'status' => 0
    		));
    	}
    }
    
    function GetUserSearchFriends(Input $Input, $Keywords = ''){
    	
    	
    	
    	if ($Keywords == ''){
    		
    		$qUser = Database::Instance()->ExecuteQuery("
	    	select * from user
	    	");
	    	$qUser = Database::Instance()->Fetch($qUser);
	    	
    	}else{
    		
    		$qUser = Database::Instance()->ExecuteQuery("
	    	select * from user where
	    	UName like '%".$Keywords."%' or
	    	FirstName like '%".$Keywords."%' or
	    	LastName like '%".$Keywords."%' or
	    	Email like '%".$Keywords."%'
	    	");
	    	$qUser = Database::Instance()->Fetch($qUser);
    		
    	}
    	
    	$return = '';
    	
    	if (count($qUser)){
    		
    	$Relation = new Userrelationship();		
		$Follow = new Userfriend();
    	
    	foreach($qUser as $item){
    		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
    		
    		$DataRelation = $Relation->CekRelation($item->UName);
    		
    		//echo $DataRelation;
    		
    		$RelationName = '';
    		if ($DataRelation){
    			$DataRelation = $Relation->GetDataRelation($item->UName);
    			$RelationName = $DataRelation[0]->RName;
    		}
    		
    		$img = '<img src="'.Config::Instance('default')->photos.'thumb1.jpg" />';
    		if ($item->AvatarFilePath){
    			$img = '<img src="'.Config::Instance('default')->photos.'p_medium_'.$item->AvatarFilePath.'.jpg" />';
    		}
    		
    		$DataFollow = $Follow->CekFollowFriend($Input, $item->UName);
    		$DataFollow_Type = 'Follow';
    		$DataFollow_TypeClass = 'buttonOrange';
    		if ($DataFollow){
    			$DataFollow_Type = 'Un Follow';
    			$DataFollow_TypeClass = 'buttonGray';
    		}

    		/*
    		 * Config::Instance('default')->photos?>p_60.jpg
    		 */
    			
    		$URL = URI::ReturnURI('App=Account&Com=Profile');
    		if ($item->UName !== $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
    		$URL = URI::ReturnURI('App=Account&Com=Profile&Act=Detail&UName='.Encryption::Encrypt($item->UName));
    		}
    		
    		Database::Instance()->SetConfig("localhost", "mastertables");
       	 	Database::Instance()->Connect();
    		$DataUser = $this->GetBasicInformation2($item->UName);
    		
    		$Gender = $DataUser->Gender;
        	$Nationality = ($DataUser->Nationality ? ' - '.$DataUser->Nationality[0]->NName : '');
        	$CurrentCity = ($DataUser->CurrentCity ? ' - '.$DataUser->CurrentCity[0]->CTName : '');
        	$Hometown = ($DataUser->Hometown ? ' - '.$DataUser->Hometown[0]->CTName : '');
    		
        	if ($item->AliasingName != $Input->Session('EDU')->GetValue('EDU_TOKENID')){
        	
        	/**
    		$return .= '
    			<li
    			data-UName="'.$item->UName.'"
    			data-AliasingName="'.$item->AliasingName.'"
    			style="position:relative;margin-bottom:10px;border-bottom:1px solid #ddd;overflow:hidden;"
    			>
                   
                    <span class="profilePicture" style="float:left;margin-right:10px;"><a href="'.$URL.'">'.$img.'</a></span>
                    <span class="title" style="display:block;font-weight:bold;font-size:12px;margin-bottom:5px;"><a href="'.$URL.'">'.$item->FirstName.' '.$item->LastName.'</a></span>
                    <span class="description">'.$item->Gender.', '.$RelationName.'</span>
                    <span class="description">'.$item->UName.' - '.$Gender.' '.$Nationality.' '.$Hometown.' '.$CurrentCity.'</span>
                     <div class="buttonContainer" style="position:absolute;top:0;right:0;">
                        <span class="'.$DataFollow_TypeClass.'"><input type="button" name="follow" id="follow" value="'.$DataFollow_Type.'" class="button" /></span>
                    </div>
                    <div class="ClearFix"></div>
                </li>
    		';
    		**/
    		
    		$return .= '
    			<li
    			data-UName="'.$item->UName.'"
    			data-AliasingName="'.$item->AliasingName.'"
    			>
		                		<a href="'.$URL.'">'.$img.'</a>
		                		<a href="'.$URL.'" class="nameList">'.$item->FirstName.' '.$item->LastName.'</a>
		                		<div class="buttonContainer" >
			                        <span class="'.$DataFollow_TypeClass.'"><input type="button" name="follow" id="follow" value="'.$DataFollow_Type.'" class="button" /></span>
			                    </div>
		                	</li>
    		';
    		
    		//}
    		
    		}
    		
    		}
    		
    	}else{
    		
    		$return = 'Not Found.';
    		
    	}
    	
    	return $return;
    	
    }
    
    function GetUserFriends(Input $Input, $Keywords = ''){
    	
    	if ($Keywords == ''){
    	$d = $this->GetUserFollowing($Input->Session('EDU')->GetValue('EDU_TOKENUNAME'));
    	}else{
    	
    		$d = Database::Instance()->ExecuteQuery("
	    	select * from user where
	    	UName like '%".$Keywords."%' or
	    	FirstName like '%".$Keywords."%' or
	    	LastName like '%".$Keywords."%' or
	    	Email like '%".$Keywords."%'
	    	");
	    	$d = Database::Instance()->Fetch($d);	
    		
    	}
    	
    	
    	$return = '';
    	
    	if (count($d)){
    	$Relation = new Userrelationship();		
		$Follow = new Userfriend();
		
    	foreach($d as $item){
    		
    		$DataRelation = $Relation->CekRelation($item->UName);
    		
    		//echo $DataRelation;
    		
    		$RelationName = '';
    		if ($DataRelation){
    			$DataRelation = $Relation->GetDataRelation($item->UName);
    			$RelationName = $DataRelation[0]->RName;
    		}
    		
    		$img = '<img src="'.Config::Instance('default')->photos.'thumb1.jpg" />';
    		if ($item->AvatarFilePath){
    			$img = '<img src="'.Config::Instance('default')->photos.'p_small_'.$item->AvatarFilePath.'.jpg" />';
    		}
    		
    		$DataFollow = $Follow->CekFollowFriend($Input, $item->UName);
    		$DataFollow_Type = 'Follow';
    		$DataFollow_TypeClass = 'buttonOrange';
    		if ($DataFollow){
    			$DataFollow_Type = 'Un Follow';
    			$DataFollow_TypeClass = 'buttonGray';
    		

    		/*
    		 * Config::Instance('default')->photos?>p_60.jpg
    		 */
    			
    		$return .= '
    			<li
    			data-UName="'.$item->UName.'"
    			data-AliasingName="'.$item->AliasingName.'"
    			style="position:relative;margin-bottom:10px;border-bottom:1px solid #ddd;overflow:hidden;"
    			>
                   
                    <span class="profilePicture" style="float:left;margin-right:10px;">'.$img.'</span>
                    <span class="title" style="display:block;font-weight:bold;font-size:12px;margin-bottom:5px;">'.$item->FirstName.' '.$item->LastName.'</span>
                    <span class="description">'.$item->Gender.', '.$RelationName.'</span>
                    <span class="description">-</span>
                     <div class="buttonContainer" style="position:absolute;top:0;right:0;">
                        <span class="'.$DataFollow_TypeClass.'"><input type="button" name="follow" id="follow" value="'.$DataFollow_Type.'" class="button" /></span>
                    </div>
                    <div class="ClearFix"></div>
                </li>
    		';
    		}
    		
    		
    	}
    		
    	}else{
    		
    		$return = 'Not Found.';
    		
    	}
    	
    	return $return;
    	
    	
    }
    
	function GetUserFindFriends(Input $Input, $datas = ''){
		
		$search = $Input->Post('SearchInput');
		
		if ($search){
	    	
	    	/*
	    	if ($FirstName && $LastName){
	    	$qUser = $this
	    				->Like('FirstName', '%'.$FirstName.'%', PDO::PARAM_STR, 'or')
	    				->Like('LastName', '%'.$LastName.'%', PDO::PARAM_STR, 'or')
	    				->Equal('Hometown', $CurrentHometown, PDO::PARAM_STR, 'and')
	    				->Equal('CurrentCity', $CurrentCity, PDO::PARAM_STR, 'or')
	    				->Like('Gender', $Gender, PDO::PARAM_STR, 'and')
	    				->Get();echo '1';
	    	}else if ($Name){
	    	$qUser = $this
	    				->Like('FirstName', '%'.$Name.'%', PDO::PARAM_STR, 'or')
	    				->Like('LastName', '%'.$Name.'%', PDO::PARAM_STR, 'or')
	    				->Equal('Hometown', $CurrentHometown, PDO::PARAM_STR, 'or')
	    				->Equal('CurrentCity', $CurrentCity, PDO::PARAM_STR, 'or')
	    				->Like('Gender', $Gender, PDO::PARAM_STR, 'or')
	    				->Get();echo '2';
	    	}else{
	    	$qUser = $this
	    				->Equal('Hometown', $CurrentHometown, PDO::PARAM_STR, 'and')
	    				->Equal('CurrentCity', $CurrentCity, PDO::PARAM_STR, 'or')
	    				->Like('Gender', $Gender, PDO::PARAM_STR, 'and')
	    				->Get();echo '3';
	    	}
	    	*/
	    	
	    	//echo $this->LastQuery();
	    	
	    	
	    	/*
	    	$qUser = $this->DBInstance()->ExecuteQuery("
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
	        (
	        user.FirstName like '%".$Name."%' or
	        user.LastName like '%".$Name."%' 
	        )
	        ");
	    	*/
	    	
	    	//echo '<pre>';
	    	//print_r($datas);
	    	//echo '</pre>';
	    	
			$qUser = $datas;
			
		}else{
		
    	$qUser = $this
    			->Limit(20)
    			->Get();	
		}
    			
    	$Relation = new Userrelationship();		
		$Follow = new Userfriend();
		
    	if ($qUser){
    		$return = '';
    	foreach($qUser as $item){
    		if ($item->AliasingName != $Input->Session('EDU')->GetValue('EDU_TOKENID')){
    		
    		$DataRelation = $Relation->CekRelation($item->UName);
    		
    		//echo $DataRelation;
    		
    		$RelationName = '';
    		if ($DataRelation){
    			$DataRelation = $Relation->GetDataRelation($item->UName);
    			$RelationName = $DataRelation[0]->RName;
    		}
    		
    		$img = '<img src="'.Config::Instance('default')->photos.'thumb1.jpg" />';
    		if ($item->AvatarFilePath){
    			$img = '<img src="'.Config::Instance('default')->photos.'p_small_'.$item->AvatarFilePath.'.jpg" />';
    		}
    		
    		$DataFollow = $Follow->CekFollowFriend($Input, $item->UName);
    		$DataFollow_Type = 'Follow';
    		$DataFollow_TypeClass = 'buttonOrange';
    		if ($DataFollow){
    			$DataFollow_Type = 'Un Follow';
    			$DataFollow_TypeClass = 'buttonGray';
    		}
    		
    		$URL = URI::ReturnURI('App=Account&Com=Profile');
    		if ($item->UName !== $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
    		$URL = URI::ReturnURI('App=Account&Com=Profile&Act=Detail&UName='.Encryption::Encrypt($item->UName));
    		}

    		/*
    		 * Config::Instance('default')->photos?>p_60.jpg
    		 */

    		/**
    		$return .= '
    			<li
    			data-UName="'.$item->UName.'"
    			data-AliasingName="'.$item->AliasingName.'"
    			>
                    <div class="buttonContainer">
                        <span class="'.$DataFollow_TypeClass.'"><input type="button" name="follow" id="follow" value="'.$DataFollow_Type.'" class="button" /></span>
                    </div>
                    <span class="profilePicture">'.$img.'</span>
                    <span class="title">'.$item->FirstName.' '.$item->LastName.'</span>
                    <span class="description">'.$item->Gender.', '.$RelationName.'</span>
                    <span class="description">-</span>
                    <div class="ClearFix"></div>
                </li>
    		';
    		**/
    		
    		$return .= '
    		<li
    			data-UName="'.$item->UName.'"
    			data-AliasingName="'.$item->AliasingName.'"
    			>
		                		<a href="'.$URL.'">'.$img.'</a>
		                		<a href="'.$URL.'" class="nameList">'.$item->FirstName.' '.$item->LastName.'</a>
		                		<div class="buttonContainer" >
			                        <span class="'.$DataFollow_TypeClass.'"><input type="button" name="follow" id="follow" value="'.$DataFollow_Type.'" class="button" /></span>
			                    </div>
		                	</li>
    		';
    		
    		$Input->Session('EDU')->SetValue('Search_Token', '');
    		
    		}
    		
    		
    		
    	}
    		return json_encode(array(
    			'status' => 1,
    			'message' => ($return ? $return : 'Not Found')
    		));
    	}else{
    		return json_encode(array(
    			'status' => 0,
    			'message' => 'Not Found'
    		));
    	}
    }
    
    function GetBasicInformation(Input $Input){
    	
    	$National = new Nationality();
    	$Country = new Country();
    	$City = new City();
    	
    	$DataUser = $this->Equal('AliasingName', $Input->Session('EDU')->GetValue('EDU_TOKENID'))
    	->First();
    	
    	$DataUser->Nationality = $National->GetDataNational($DataUser->Nationality);
    	$DataUser->Hometown = $City->GetDataCity($DataUser->Hometown);
    	$DataUser->CurrentCity = $City->GetDataCity($DataUser->CurrentCity);
    	return $DataUser;
    }
    
	function GetBasicInformation2($Id){
    	
    	$National = new Nationality();
    	$Country = new Country();
    	$City = new City();
    	
    	$DataUser = $this->Equal('UName', $Id)
    	->First();
    	$DataUser->Nationality = $National->GetDataNational($DataUser->Nationality);
    	$DataUser->Hometown = $City->GetDataCity($DataUser->Hometown);
    	$DataUser->CurrentCity = $City->GetDataCity($DataUser->CurrentCity);
    	return $DataUser;
    }
	
    function SaveBasicInformation(Input $Input){
    	
    	$firstname = $Input->Post('firstname');
    	$lastname = $Input->Post('lastname');
    	
    	$currentCity_Input = $Input->Post('currentCity_Input');
    	$homeTown_Input = $Input->Post('homeTown_Input');
    	$national_Input = $Input->Post('national_Input');
    	$religion = $Input->Post('religion');
    	$gender = $Input->Post('gender');
    	$birthday = $Input->Post('bdayYear') . '-' .$Input->Post('bdayMonth') .'-'. $Input->Post('bdayDay')  ;
    	$optionShowBirthday = $Input->Post('optionShowBirthday');
    	$aboutMe = $Input->Post('aboutMe');
    	$interestedIn = $Input->Post('interestedIn');
    	
    	$RelationType = $Input->Post('relationshipStatus');
    	$RelationToName = $Input->Post('relationInput');
    	
    	$return_interestedIn = '';
    	for($i = 0; $i<count($interestedIn); $i++){
    		$return_interestedIn .= $interestedIn[$i];
    		if ($i != count($interestedIn) - 1) $return_interestedIn .= ', ';
    	}
    	
    	//echo $Input->Session('EDU')->GetValue('EDU_TOKENID').'->';
    	
    	
    	$User = new User();   	
    	$DataUserUpdate = $User->Equal('AliasingName', $Input->Session('EDU')->GetValue('EDU_TOKENID'))->First();
    	
    	$DataUserUpdate->FirstName = $firstname;
    	$DataUserUpdate->LastName = $lastname;
    	
    	$DataUserUpdate->Gender = $gender;
    	$DataUserUpdate->Nationality = $national_Input;
    	$DataUserUpdate->CurrentCity = $currentCity_Input;
    	$DataUserUpdate->Hometown = $homeTown_Input;
    	$DataUserUpdate->Religion = $religion;
    	$DataUserUpdate->Gender = $gender;
    	$DataUserUpdate->Birthday = $birthday;
    	$DataUserUpdate->ShowBirthday = $optionShowBirthday;
    	$DataUserUpdate->AboutMe = $aboutMe;
    	$DataUserUpdate->Interest = $return_interestedIn;
    	$User->Update($DataUserUpdate);
    	
    	
    	$UserRelation = new Userrelationship();
    	if ($RelationType != 1){
    	
		if ($UserRelation->CekRelation($Input->Session('EDU')->GetValue('EDU_TOKENUNAME'))){
			$DataUserUpdate = $UserRelation->Equal('URUName', $Input->Session('EDU')->GetValue('EDU_TOKENUNAME'))->First();
			$DataUserUpdate->RID = $RelationType;
			$DataUserUpdate->URToUName = $RelationToName;
			$UserRelation->Update($DataUserUpdate);
			
			$DataUserUpdate = $UserRelation->Equal('URToUName', $Input->Session('EDU')->GetValue('EDU_TOKENUNAME'))->First();
			$DataUserUpdate->RID = $RelationType;
			$DataUserUpdate->URUName = $RelationToName;
			$UserRelation->Update($DataUserUpdate);
		}else{
			$DataUserUpdate = new UserrelationshipEntity();
			
			$DataUserUpdate->RID = $RelationType;
			$DataUserUpdate->URUName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
			$DataUserUpdate->URToUName = $RelationToName;
			$UserRelation->Add($DataUserUpdate);
			
			$DataUserUpdate->RID = $RelationType;
			$DataUserUpdate->URUName = $RelationToName;
			$DataUserUpdate->URToUName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
			$UserRelation->Add($DataUserUpdate);
		}
		
    	}else{
    		
    		$DataUserDelete = $UserRelation->Equal('URUName', $Input->Session('EDU')->GetValue('EDU_TOKENUNAME'))->First();
			$UserRelation->Delete($DataUserDelete);
			
			$DataUserDelete = $UserRelation->Equal('URToUName', $Input->Session('EDU')->GetValue('EDU_TOKENUNAME'))->First();
			$UserRelation->Delete($DataUserDelete);
    		
    	}
    	
    	
    	return json_encode(array('status' => 1));

    }
    
    function SaveEmploye(Input $Input){
    	$Employe = $Input->Post('employers');
    	$User = new User();   	
    	$DataUserUpdate = $User->Equal('AliasingName', $Input->Session('EDU')->GetValue('EDU_TOKENID'))->First();
    	$DataUserUpdate->EmployersAt = $Employe;
    	$User->Update($DataUserUpdate);
    	return json_encode(array('status' => 1));
    }
    
    function SaveEntertaiment(Input $Input){
    	$Musics = $Input->Post('Musics');
    	$Books = $Input->Post('Books');
    	$Movies = $Input->Post('Movies');
    	
    	$Usermusic = new Usermusic();
    	$Userbooks = new Userbooks();
    	$UserMovies = new Usermovies();
    	
    	
    	$UsermusicDelete = $Usermusic->Equal('_AliasingName', $Input->Session('EDU')->GetValue('EDU_TOKENID'))->Get();
		$Usermusic->Delete($UsermusicDelete);
		
		$UserbooksDelete = $Userbooks->Equal('_AliasingName', $Input->Session('EDU')->GetValue('EDU_TOKENID'))->Get();
		$Userbooks->Delete($UserbooksDelete);
		
		$UserMoviesDelete = $UserMovies->Equal('_AliasingName', $Input->Session('EDU')->GetValue('EDU_TOKENID'))->Get();
		$UserMovies->Delete($UserMoviesDelete);
    	
    	if ($Musics){
    	$ListMusics = $Musics;
    	
    	foreach($ListMusics as $Music){
    		if ($Music){
    		$EnMusics = new UsermusicEntity();
			$EnMusics->_AliasingName = $Input->Session('EDU')->GetValue('EDU_TOKENID');
			$EnMusics->UMNameMusic = $Music;
			$Usermusic->Add($EnMusics);
    		}
    	}
    	}
    	
    	if ($Books){
    	$ListBooks = $Books;
    	
    	foreach($ListBooks as $Book){
    		if ($Book){
    		$EnBooks = new UserbooksEntity();
			$EnBooks->_AliasingName = $Input->Session('EDU')->GetValue('EDU_TOKENID');
			$EnBooks->UBNameBook = $Book;
			$Userbooks->Add($EnBooks);
    		}
    	}
    	}
    	
    	if ($Movies){
    	$ListMovies = $Movies;

    	foreach($ListMovies as $Movies){
    		if ($Movies){
    		$EnMovies = new UsermoviesEntity();
			$EnMovies->_AliasingName = $Input->Session('EDU')->GetValue('EDU_TOKENID');
			$EnMovies->UMVNameMovie = $Movies;
			$UserMovies->Add($EnMovies);
    		}
    	}
    	}
    	
    	return json_encode(array('status' => 1));
    	
    }
    
    function SaveInterest(Input $Input){
    	
    	$Hobby = $Input->Post('Hobby');
    	
    	$Userhobby = new Userhobby();
    	
    	$UserhobbyDelete = $Userhobby->Equal('_AliasingName', $Input->Session('EDU')->GetValue('EDU_TOKENID'))->Get();
		$Userhobby->Delete($UserhobbyDelete);
    	
		if ($Hobby){
		$ListHobby = $Hobby;
    	
    	foreach($ListHobby as $h){
    		if ($h){
    		$EnHobby = new UserhobbyEntity();
			$EnHobby->_AliasingName = $Input->Session('EDU')->GetValue('EDU_TOKENID');
			$EnHobby->UHHobby = $h;
			$Userhobby->Add($EnHobby);
    		}
    	}
		}
		
		return json_encode(array('status' => 1));
		
    }
    
	public function validateEmail($email){
		if (!preg_match('/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i',$email)) return 1;
		else return 0;
	}
    
    function SaveUpdateContactInformation(Input $Input){
    	
    	$Email = $Input->Post('Email');
    	
    	$ValidateEmail = $this->validateEmail($Email);
    	
    	if ($ValidateEmail == 1){
    		return json_encode(array(
    			'status' => 0,
    			'message' => 'Format email salah.'
    		));
    	}else{
    		
    		$Address = $Input->Post('Address');
    		
    		
    		$User = new User();   	
	    	$DataUserUpdate = $User->Equal('AliasingName', $Input->Session('EDU')->GetValue('EDU_TOKENID'))->First();
	    	
	    	$DataUserUpdate->Address = $Address;
	    	$DataUserUpdate->Email = $Email;
	    	
	    	$User->Update($DataUserUpdate);
    		
    		
	    	$Phone = $Input->Post('Phone');
	    	
	    	$Userphone = new Userphone();
	    	
	    	$UserphoneDelete = $Userphone->Equal('_AliasingName', $Input->Session('EDU')->GetValue('EDU_TOKENID'))->Get();
			$Userphone->Delete($UserphoneDelete);
	    	
			if ($Phone){
			$ListPhone = $Phone;
	    	
			foreach($ListPhone as $k => $v){
				if ($v['Type'] && $v['Phone']){
					$EnPhone = new UserphoneEntity();
		    		$EnPhone->UTPID = $v['Type'];
					$EnPhone->_AliasingName = $Input->Session('EDU')->GetValue('EDU_TOKENID');
					$EnPhone->UPPhone = $v['Phone'];
					$Userphone->Add($EnPhone);
				}
			}
			}
    		
			return json_encode(array('status' => 1));
			
    	}
    	    	
    }
    
    function UpdateAvatar($filename, $TokenId){
    	
    	$User = new User();   	
    	$DataUserUpdate = $User->Equal('AliasingName', $TokenId)->First();
    	
    	$NameImage = $DataUserUpdate->AvatarFilePath;
    	
    	if ($NameImage){
			$gallery_path = 'Photos/';
			$locationimage = $gallery_path.'p_big_'.$NameImage.'.jpg';
			
			$fh = fopen($locationimage, 'w');
			fclose($fh);
			unlink($locationimage);
			
			//$gallery_path = 'Photos/medium/';
			$locationimage = $gallery_path.'p_medium_'.$NameImage.'.jpg';
			
			$fh = fopen($locationimage, 'w');
			fclose($fh);
			unlink($locationimage);
			
			//$gallery_path = 'Photos/small/';
			$locationimage = $gallery_path.'p_small_'.$NameImage.'.jpg';
			
			$fh = fopen($locationimage, 'w');
			fclose($fh);
			unlink($locationimage);
		}
    	
    	$DataUserUpdate->AvatarFilePath = $filename;
    	$User->Update($DataUserUpdate);
    	
    }
    
    function DeleteAvatar(Input $Input){
   		$User = new User();   	
    	$DataUserUpdate = $User->Equal('AliasingName', $Input->Session('EDU')->GetValue('EDU_TOKENID'))->First();
    	
    	$NameImage = $DataUserUpdate->AvatarFilePath;
    	
   	 	if ($NameImage){
			$gallery_path = 'Photos/';
			$locationimage = $gallery_path.'p_big_'.$NameImage.'.jpg';
			
			$fh = fopen($locationimage, 'w');
			fclose($fh);
			unlink($locationimage);
			
			//$gallery_path = 'Photos/medium/';
			$locationimage = $gallery_path.'p_medium_'.$NameImage.'.jpg';
			
			$fh = fopen($locationimage, 'w');
			fclose($fh);
			unlink($locationimage);
			
			//$gallery_path = 'Photos/small/';
			$locationimage = $gallery_path.'p_small_'.$NameImage.'.jpg';
			
			$fh = fopen($locationimage, 'w');
			fclose($fh);
			unlink($locationimage);
		}
		
		$DataUserUpdate->AvatarFilePath = '';
    	$User->Update($DataUserUpdate);
		
		return json_encode(array('status' => 1, 'url' => Config::Instance('default')->baseUrl . 'Account/NewsFeeds'));
		
    }

    public function ChangeStatus($status, Input $Input) {
        $selectedUser = $this->Equal('AliasingName', $Input->Session('EDU')->GetValue('EDU_TOKENID'))->First();
        $selectedUser->Status = $status;

        $Input->Session('EDU')->SetValue('EDU_STATUS', $status);

        $this->Update($selectedUser);
    }
    
	public function ValidateLogin(Input $Input, $status = 'LogedIn') {
        $EDU_TOKENID = $Input->Session('EDU')->GetValue('EDU_TOKENID');

        switch($status) {
            case 'LogedIn':
                if ( ! isset($EDU_TOKENID) || empty($EDU_TOKENID) ) {
                    redirect(URI::ReturnURI('App=Account&Com=Login'));
                }
                break;

            case 'LogedOut':
                if ( ! empty($EDU_TOKENID) ) {
                    redirect(URI::ReturnURI('App=Account&Com=NewsFeeds'));
                }
                break;
        }

        return $this;
    }

    public function ValidateLoginStatus($status, Input $Input) {
        $EDU_STATUS = $Input->Session('EDU')->GetValue('EDU_STATUS');

        switch($status) {
            case 'New':
                if ($EDU_STATUS == 'Activated') {
                    redirect(URI::ReturnURI('App=Account&Com=NewsFeeds'));
                }
                break;

            case 'Activated':
                if ($EDU_STATUS == 'New') {
                    redirect(URI::ReturnURI('App=Account&Com=GettingStarted'));
                }
                break;
        }
    }
    
public function GetUserProfile($UName) {
        $query = Database::Instance()->ExecuteQuery("
            SELECT * FROM user
            WHERE UName = '".$UName."'
        ");

        $data = Database::Instance()->Fetch($query);

        if (count($data) > 0)
            return $data[0];
        return FALSE;
    }
    
public function GetUserFollower($UName) {
        $query = Database::Instance()->ExecuteQuery("
            SELECT * FROM user WHERE UName IN (
                SELECT UName FROM userfriend
                WHERE UFRName = '".$UName."'
            )
        ");

        return Database::Instance()->Fetch($query);
    }

    public function GetUserFollowing($UName) {
        $query = Database::Instance()->ExecuteQuery("
            SELECT * FROM user WHERE UName IN (
                SELECT UFRName FROM userfriend
                WHERE UName = '".$UName."'
            )
        ");

        return Database::Instance()->Fetch($query);
    }
    
    
}

?>