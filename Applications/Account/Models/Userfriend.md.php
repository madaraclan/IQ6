<?php

Import::Entity('Account.Userfriend');

class Userfriend extends Model{
	
	public function __construct() {
        parent::__construct();
        $this->tableName = 'userfriend';
        $this->lastTable = 'userfriend';
        $this->application = 'Account';
    }
    
    public $CountFollowing;
    
    function following(Input $Input){
    	$UName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
    	$stmt = Database::Instance()->ExecuteQuery("
    	select user.UName, user.FirstName, user.LastName, user.AvatarFilePath from user
    	where user.UName in(
    	select UFRName from userfriend
    	where UName = '".$UName."'
    	)
    	");
    	$datas = Database::Instance()->Fetch($stmt);
        
    	$count = count($datas);
    	
    	$this->CountFollowing = $count;
    	
    	$return = '';
    	
    	
    	
    	if ($count){
    	
    	foreach($datas as $item){
    		$img = 'thumb1.jpg';
    		if ($item->AvatarFilePath){
    			$img = 'p_small_'.$item->AvatarFilePath.'.jpg';
    		}
    		
    		$URL = URI::ReturnURI('App=Account&Com=Profile');
    			if ($item->UName !== $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
    			$URL = URI::ReturnURI('App=Account&Com=Profile&Act=Detail&UName='.Encryption::Encrypt($item->UName));
    			}
    			
    			$ProfileUrl = '
    			title="'.$item->FirstName.' '.$item->LastName.'" href="'.$URL.'"
    			';
    		$return .= '
    		<li><a '.$ProfileUrl.'><img src="'.Config::Instance(SETTING_USE)->photos.$img.'" /></a></li>
    		';
    		
    	}
    	
    	}
    	
    	return $return;
    }
    
	public $CountFollowers;
    
    function followers(Input $Input){
    	$UName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
    	$stmt = Database::Instance()->ExecuteQuery("
    	select user.UName, user.FirstName, user.LastName, user.AvatarFilePath from user
    	where user.UName in(
    	select UName from userfriend
    	where UFRName = '".$UName."'
    	)
    	");
    	$datas = Database::Instance()->Fetch($stmt);
        
    	$count = count($datas);
    	
    	$this->CountFollowers = $count;
    	
    	$return = '';
    	
    	if ($count){
    	
    	foreach($datas as $item){
    		$img = 'thumb1.jpg';
    		if ($item->AvatarFilePath){
    			$img = 'p_small_'.$item->AvatarFilePath.'.jpg';
    		}
    		
    		$URL = URI::ReturnURI('App=Account&Com=Profile');
    			if ($item->UName !== $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
    			$URL = URI::ReturnURI('App=Account&Com=Profile&Act=Detail&UName='.Encryption::Encrypt($item->UName));
    			}
    			
    			$ProfileUrl = '
    			title="'.$item->FirstName.' '.$item->LastName.'" href="'.$URL.'"
    			';
    		
    		$return .= '
    		<li><a '.$ProfileUrl.'><img src="'.Config::Instance(SETTING_USE)->photos.$img.'" /></a></li>
    		';
    		
    	}
    	
    	}
    	
    	return $return;
    }
    
    function MutedFriend(Input $Input){
    	$UFRName = $Input->post('IdTeman');
    	$UName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
    	$DataFriend = $this
    						->Equal('UName', $UName)
    						->Equal('UFRName', $UFRName)
    						->First();
    	
    	$DataFriend->Muted = 1;
    	$this->Update($DataFriend);
    }
    
    function FollowFriend(Input $Input){
    	$DataUserUpdate = new UserfriendEntity();
		$DataUserUpdate->UName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
		$DataUserUpdate->UFRName = $Input->Post('EDU_TOKENUNAME');
		$DataUserUpdate->Muted = 0;
		$this->Add($DataUserUpdate);
    }
    
	function UnFollowFriend(Input $Input){
    	$DataUserDelete = 
    				$this
    					->Equal('UName', $Input->Session('EDU')->GetValue('EDU_TOKENUNAME'))
    					->Equal('UFRName', $Input->Post('EDU_TOKENUNAME'))
    					->First();
		$this->Delete($DataUserDelete);
    }
	
	function CekFollowFriend(Input $Input, $TokenId){
		
		$Follow = Database::Instance()->ExecuteQuery("
    	select * from userfriend where
    	UName = '".$Input->Session('EDU')->GetValue('EDU_TOKENUNAME')."' and
    	UFRName = '".$TokenId."'
    	");
    	$Follow = Database::Instance()->Fetch($Follow);
		
    	//$Follow = $this
    	//			->Equal('UName', $Input->Session('EDU')->GetValue('EDU_TOKENUNAME'))
    	//			->Equal('UFRName', $TokenId)
    	//			->First();
    	
    	return count($Follow);
    }
    
    function PictureFriendTag(Input $Input){
    	
    	
    	$PictureFriend = $this
    						->Join('user', 'user.UName', 'userfriend.UFRName')
    						->Equal('userfriend.UName', $Input->Session('EDU')->GetValue('EDU_TOKENUNAME'))
    						->Get();
    	
    	$picture = array();
    	$Uname = array();
    	$fullname = array();
    	$addtional = array();
    	
    	$National = new Nationality();
    	$Country = new Country();
    	$City = new City();
    	
    	foreach($PictureFriend as $item){
    		
    		$Nationality = $National->GetDataNational($item->Nationality);
	    	$Hometown = $City->GetDataCity($item->Hometown);
	    	$CurrentCity = $City->GetDataCity($item->CurrentCity);
	    	
	    	$place = '';
	    	if ($Hometown) $place = ' - '.($Hometown ? $Hometown[0]->CTName : '');
	    	else if ($CurrentCity) $place = ' - '.($CurrentCity ? $CurrentCity[0]->CTName : '');
	    	else $place = '';
	    	    		
    		$picture[] = '"<img src=\''.($item->AvatarFilePath ? Config::Instance('default')->photos.'p_small_'.$item->AvatarFilePath.'.jpg' : Config::Instance('default')->photos.'thumb1.jpg').'\' />"';
    		$Uname[] = '"'.$item->UFRName.'"';
    		$fullname[] = '"'.$item->FirstName.' '.$item->LastName.'"';
    		$addtional[] = '"'.$item->Gender.''.$place.'"';
    		
    	}
    	
    	$picture = join(',', $picture);
    	$Uname = join(',', $Uname);
    	$fullname = join(',', $fullname);
    	$addtional = join(',', $addtional);
    	
    	return json_encode(array(
    		'picture' => $picture,
    		'uname' => $Uname,
    		'fullname' => $fullname,
    		'addtional' => $addtional
    	));
    	
    }
    
}

?>