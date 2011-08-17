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

class _AjaxFriends extends Controller{
	
	public $TokenId;
	
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
	
	
}