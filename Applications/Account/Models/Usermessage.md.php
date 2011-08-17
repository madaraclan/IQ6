<?php

Import::Entity('Account.Usermessage');
Import::Entity('Account.Usermessagereply');

class Usermessage extends Model{

	public function __construct() {
        parent::__construct();
        $this->tableName = 'usermessage';
        $this->lastTable = 'usermessage';
        $this->application = 'Account';
    }
    
    public function JmlReadMessage($UName){
    	Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        
        $stmt = Database::Instance()->ExecuteQuery("
    	select * from usermessagenotif
    	where UMNUName = '".$UName."'
    	");
        
        $result = Database::Instance()->Fetch($stmt);
        $jml = 0;
        foreach($result as $item){
        	if (!$item->UMNIsRead) $jml++;
        }
        
        return $jml;
        
    }
    
    public function SendMessageDetail($UName, $IdMessageReply, $MessageReplyText, $IsRead){
    	
    	Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        
        $stmt = Database::Instance()->ExecuteQuery("
    	insert into usermessagereply set
    	UMSID = '".$IdMessageReply."',
    	UName = '".$UName."',
    	UMRContent = '".$MessageReplyText."'
    	");
        
        Database::Instance()->SetConfig("localhost", "socialnetwork");
	        Database::Instance()->Connect();
	    	$stmt = Database::Instance()->ExecuteQuery("
	    	update usermessagenotif set
	    	UMNIsRead = ".$IsRead."
	    	where
	    	UMSID = '".$IdMessageReply."' and
	    	UMNUName = '".$UName."'
	    	");
	    	
	     Database::Instance()->SetConfig("localhost", "socialnetwork");
	        Database::Instance()->Connect();
	    	$stmt = Database::Instance()->ExecuteQuery("
	    	update usermessagenotif set
	    	UMNIsRead = 0
	    	where
	    	UMSID = '".$IdMessageReply."' and
	    	UMNUName != '".$UName."'
	    	");
    	
        $stmt = Database::Instance()->ExecuteQuery("
    	select * from usermessagereply
    	where
    	UMSID = '".$IdMessageReply."' and
    	UName = '".$UName."' and
    	UMRContent = '".$MessageReplyText."'
    	");
    	$result = Database::Instance()->Fetch($stmt);
    	$result = $result[0];
    	
    	
    	$UserSignIn = new User();
			
		Database::Instance()->SetConfig("localhost", "mastertables");
	   	Database::Instance()->Connect();
    	
    	$DataUser = ($UserSignIn->GetBasicInformation2($UName));
    		
    			$AvatarFilePath = $DataUser->AvatarFilePath;
		    	if (!$AvatarFilePath) $AvatarFilePath = '';
				
		    	if (!$AvatarFilePath){ 
		            $Avatar = '<img src="'.Path::Template('Images/thumb1.jpg').'" />';
		    	}else{
		    		$Avatar = '<img src="'.Config::Instance('default')->photos.'p_small_'.$AvatarFilePath.'.jpg" />';
		    	}
		    	
		    	$Name = $DataUser->FirstName.' '.$DataUser->LastName;
    			$Content = $result->UMRContent;
    			$Time = $result->UMRTime;
    			
    			$_dt = date('j M Y G:i:s', strtotime($Time));
    			
    			$Time2 = $this->relativeTime($_dt);
		    	
    		$return = '
    					<li data-idmessagereply="'.$result->UMRID.'">
								<div class="images-thumbs">
									'.$Avatar.'
								</div>
								<div class="details">
									<h2>'.$Name.'</h2>
									<p>'.$this->convert_url($Content).'
									</p>
								</div>
								<div class="datetime">'.$Time2.'</div>
						</li>
    		';
    		
    	return $return;	
        
    }
    
    public function SendMessage($From, $To, $Content, $Status){
    	
    	Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
    	$stmt = Database::Instance()->ExecuteQuery("
    	insert into usermessage set
    	UMSFrom = '".$From."',
    	UMSTo = '".$To."',
    	UMSContent = '".$Content."',
    	UMSStatus = '".$Status."'
    	");
    	
    	$stmt = Database::Instance()->ExecuteQuery("
    	select * from usermessage
    	where
    	UMSFrom = '".$From."' and
    	UMSTo = '".$To."' and
    	UMSContent = '".$Content."' and
    	UMSStatus = '".$Status."'
    	");
    	$result = Database::Instance()->Fetch($stmt);
    	$result = $result[0];
    		
    		Database::Instance()->SetConfig("localhost", "socialnetwork");
	        Database::Instance()->Connect();
	    	$stmt = Database::Instance()->ExecuteQuery("
	    	insert into usermessagenotif set
	    	UMSID = '".$result->UMSID."',
	    	UMNUName = '".$From."',
	    	UMNIsRead = 1
	    	");
	    	
	    	$ex = explode(',', $To);
	    	foreach($ex as $User){
	    		Database::Instance()->SetConfig("localhost", "socialnetwork");
		        Database::Instance()->Connect();
		    	$stmt = Database::Instance()->ExecuteQuery("
		    	insert into usermessagenotif set
		    	UMSID = '".$result->UMSID."',
		    	UMNUName = '".$User."',
		    	UMNIsRead = 0
		    	");
	    	}
    	
    	$stmt = Database::Instance()->ExecuteQuery("
    	insert into usermessagereply set
    	UMSID = '".$result->UMSID."',
    	UName = '".$From."',
    	UMRContent = '".$Content."'
    	");
    	
    }
    
    public function GetMessageDetail($User, $IdMessage, $UName){
    	
    	Database::Instance()->SetConfig("localhost", "socialnetwork");
	        Database::Instance()->Connect();
	    	$stmt = Database::Instance()->ExecuteQuery("
	    	update usermessagenotif set
	    	UMNIsRead = 1
	    	where
	    	UMSID = '".$IdMessage."' and
	    	UMNUName = '".$UName."'
	    	");
    	
    	Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
    	$stmt = Database::Instance()->ExecuteQuery("
    	select * from 
    	usermessage
    	where 
    	UMSID = '".$IdMessage."'
    	order by UMSTime desc
    	limit 1
    	");
    	
    	 
    	
    	$result = Database::Instance()->Fetch($stmt);
    	$result = $result[0];
    	
    	$UserSignIn = new User();
			
		Database::Instance()->SetConfig("localhost", "mastertables");
	   	Database::Instance()->Connect();
    	
    		$To = $result->UMSTo;
    		$ex = explode(',', $To);
	        $pic = '';
	        $countex = count($ex);
	        $UserTo = '';
	        $i = 0;
	        foreach($ex as $t){
			$DataUser = ($UserSignIn->GetBasicInformation2($t));
			
	       		$AvatarFilePath = $DataUser->AvatarFilePath;
		    	if (!$AvatarFilePath) $AvatarFilePath = '';
				
		    	if (!$AvatarFilePath){ 
		            $Avatar = '<img src="'.Path::Template('Images/thumb1.jpg').'" />';
		    	}else{
		    		$Avatar = '<img src="'.Config::Instance('default')->photos.'p_small_'.$AvatarFilePath.'.jpg" />';
		    	}
		    	
		    	if ($i <= 2)
		    	$pic .= $Avatar;
		    	
		    	$UserTo .= $DataUser->FirstName.' '.$DataUser->LastName;
		    	
		    	++$i;
		    	
		    	if ($i != $countex) $UserTo .= ', '; 
			
	        }
    	
	    $TitleMessage = $UserTo;    
	        
    	
    	Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
    	$stmt = Database::Instance()->ExecuteQuery("
    	select * from
    	usermessagereply
    	where 
    	UMSID = '".$IdMessage."'
    	order by UMRID desc
    	");
    	
    	$result = Database::Instance()->Fetch($stmt);
    	
    	$return = '';
    	
    	$UserSignIn = new User();
			
		Database::Instance()->SetConfig("localhost", "mastertables");
	   	Database::Instance()->Connect();
    	
    	foreach($result as $item){
    		
    		$DataUser = ($UserSignIn->GetBasicInformation2($item->UName));
    		
    			$AvatarFilePath = $DataUser->AvatarFilePath;
		    	if (!$AvatarFilePath) $AvatarFilePath = '';
				
		    	if (!$AvatarFilePath){ 
		            $Avatar = '<img src="'.Path::Template('Images/thumb1.jpg').'" />';
		    	}else{
		    		$Avatar = '<img src="'.Config::Instance('default')->photos.'p_small_'.$AvatarFilePath.'.jpg" />';
		    	}
		    	
		    	$Name = $DataUser->FirstName.' '.$DataUser->LastName;
    			$Content = $item->UMRContent;
    			$Time = $item->UMRTime;
    			
    			$_dt = date('j M Y G:i:s', strtotime($Time));
    			
    			$Time2 = $this->relativeTime($_dt);
		    	
    		$return .= '
    					<li data-idmessagereply="'.$item->UMRID.'">
								<div class="images-thumbs">
									'.$Avatar.'
								</div>
								<div class="details">
									<h2>'.$Name.'</h2>
									<p>'.$this->convert_url($Content).'
									</p>
								</div>
								<div class="datetime">'.$Time2.'</div>
						</li>
    		';
    		
    	}
    	
    	
    	return array(
    		'TitleMessage' => $TitleMessage,
    		'DetailMessage' => $return,
    		'IdMessage' => $IdMessage
    	);
    	
    }
    
    public function GetMessageRealtime($LastId, $IdMessage){
    	Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
    	$stmt = Database::Instance()->ExecuteQuery("
    	select * from
    	usermessagereply
    	where 
    	UMSID = '".$IdMessage."' and
    	UMRID > '".$LastId."'
    	order by UMRID desc
    	");
    	
    	$result = Database::Instance()->Fetch($stmt);
    	
    	$return = '';
    	
    	$UserSignIn = new User();
			
		Database::Instance()->SetConfig("localhost", "mastertables");
	   	Database::Instance()->Connect();
    	
    	foreach($result as $item){
    		
    		$DataUser = ($UserSignIn->GetBasicInformation2($item->UName));
    		
    			$AvatarFilePath = $DataUser->AvatarFilePath;
		    	if (!$AvatarFilePath) $AvatarFilePath = '';
				
		    	if (!$AvatarFilePath){ 
		            $Avatar = '<img src="'.Path::Template('Images/thumb1.jpg').'" />';
		    	}else{
		    		$Avatar = '<img src="'.Config::Instance('default')->photos.'p_small_'.$AvatarFilePath.'.jpg" />';
		    	}
		    	
		    	$Name = $DataUser->FirstName.' '.$DataUser->LastName;
    			$Content = $item->UMRContent;
    			$Time = $item->UMRTime;
    			
    			$_dt = date('j M Y G:i:s', strtotime($Time));
    			
    			$Time2 = $this->relativeTime($_dt);
		    	
    		$return .= '
    					<li data-idmessagereply="'.$item->UMRID.'">
								<div class="images-thumbs">
									'.$Avatar.'
								</div>
								<div class="details">
									<h2>'.$Name.'</h2>
									<p>'.$this->convert_url($Content).'
									</p>
								</div>
								<div class="datetime">'.$Time2.'</div>
						</li>
    		';
    		
    	}
    	
    	
    	return $return;
    	
    }
    
    public function GetMessageFront($User, $limit = "", $UName = ""){
    	    	
    	$_Limit = '';
    	if ($limit) $_Limit = 'limit '.$limit;
    	
    	Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
    	$stmt = Database::Instance()->ExecuteQuery("
    	select * from 
    	usermessage where
    	UMSFrom like '%".$User."%' or 
    	UMSTo like '%".$User."%'
    	order by UMSTime desc
    	".$_Limit."
    	");
    	
    	$result = Database::Instance()->Fetch($stmt);
    	
    	$return = '';
    	
    	foreach($result as $item){
    		
    		$From = $item->UMSFrom;
    		$To = $item->UMSTo;
    		$Content = $item->UMSContent;
    		$Time = $item->UMSTime;
    		$Status = $item->UMSStatus;
    		$UMSID = $item->UMSID;
    		
    		Database::Instance()->SetConfig("localhost", "socialnetwork");
    		Database::Instance()->Connect();
    		$stmt1 = Database::Instance()->ExecuteQuery("
	    	select * from 
	    	usermessagereply where
	    	UMSID = '".$UMSID."'
	    	order by UMRID desc
	    	limit 1
	    	");
	    	
	    	$result1 = Database::Instance()->Fetch($stmt1);
	    	$result1 = $result1[0];
	    	
	    	$Content = $result1->UMRContent;
    		
    		$_dt = date('j M Y G:i:s', strtotime($Time));
    		
    		if (is_string($Time)){
				$Time=strtotime($Time);
			}
    		
			$Time = $this->relativeTime($Time);
			$Time2 = $this->relativeTime($_dt);
			
			$UserSignIn = new User();
			
			Database::Instance()->SetConfig("localhost", "mastertables");
	        Database::Instance()->Connect();
			
	        $ex = explode(',', $To);
	        $pic = '';
	        $countex = count($ex);
	        $UserTo = '';
	        $i = 0;
	        foreach($ex as $t){
			$DataUser = ($UserSignIn->GetBasicInformation2($t));
			
	       		$AvatarFilePath = $DataUser->AvatarFilePath;
		    	if (!$AvatarFilePath) $AvatarFilePath = '';
				
		    	if (!$AvatarFilePath){ 
		            $Avatar = '<img src="'.Path::Template('Images/thumb1.jpg').'" />';
		    	}else{
		    		$Avatar = '<img src="'.Config::Instance('default')->photos.'p_small_'.$AvatarFilePath.'.jpg" />';
		    	}
		    	
		    	if ($i <= 2)
		    	$pic .= $Avatar;
		    	
		    	$UserTo .= $DataUser->FirstName.' '.$DataUser->LastName;
		    	
		    	++$i;
		    	
		    	if ($i != $countex) $UserTo .= ', '; 
			
	        }
	        
	        
	        Database::Instance()->SetConfig("localhost", "socialnetwork");
	        Database::Instance()->Connect();
	    	$stmt = Database::Instance()->ExecuteQuery("
	    	select * from usermessagenotif where 
	    	UMSID = '".$UMSID."' and
	    	UMNUName = '".$UName."'
	    	");
	    		    	
	    	$result1 = Database::Instance()->Fetch($stmt);
	    	
	    	//$IsRead = 0;
	    	
	    	//if (count($result1)){
    		$result1 = $result1[0];
    		
    		$IsRead = $result1->UMNIsRead;
	    	//}
    		
    		$Te = 'Read';
    		if (!$IsRead) $Te = 'NoRead';
	        
    		$return .= '
    					<li class="'.$Te.'">
							<a href="#" data-idmessage="'.$UMSID.'">
								<div class="images-thumbs">
									'.$pic.'
								</div>
								<div class="details">
									<h2>'.$UserTo.'</h2>
									<p>
									'.$Content.'
									</p>
								</div>
								<div class="datetime">'.$Time2.'</div>
							</a>
						</li>
    		';
    	}
    	
    	return $return;
    	
    }
    
	public function relativeTime($time){
		$divisions = array(1,60,60,24,7,4.34,12);
		$names = array('second','minute','hour','day','week','month','year');
		$time = time() - strtotime($time);
		$name = "";
		
		if ($time < 10) return 'just now';
		
		for($i=0; $i<count($divisions); $i++){
			if ($time < $divisions[$i]) break;
			$time = $time / $divisions[$i];
			$name = $names[$i];
		}
		
		$time = round($time);
		if ($time != 1) $name .= 's';
		
		return $time.$name.' ago';
		
	}
	
	
	function convert_url($ret){

 		
 			if (mb_strlen($ret,'utf8')<1) return false;
			//$ret = preg_replace("/http\:\/\/vimeo.com\/([0-9a-zA-Z-_]*)/","<a href=\"\\0\" class=\"fetch\" target=\"_blank\">\\0</a>",$ret);
			//$ret = preg_replace("/http\:\/\/www\.youtube\.com\/(v\/|watch\?v=)([0-9a-zA-Z-_]*)/","<a href=\"\\0\" class=\"fetch\" target=\"_blank\">\\0</a>",$ret);
			//$ret = preg_replace("/http\:\/\/www\.flickr\.com\/photos\/([0-9a-zA-Z-_@]*)\/([0-9a-zA-Z-_]*)\//","<a href=\"\\0\" class=\"fetch\" target=\"_blank\">\\0</a>",$ret);
			//$ret = preg_replace("/http\:\/\/twitpic.com\/([0-9a-zA-Z-_]*)/","<a href=\"\\0\" class=\"fetch\" target=\"_blank\">\\0</a>",$ret);
			//$ret = preg_replace("/http\:\/\/(\w+).wikipedia.org\/wiki\/([0-9a-zA-Z-_]*)/","<a href=\"\\0\" class=\"fetch\" target=\"_blank\">\\0</a>",$ret);
			$ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $ret);
			$ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $ret);	
			
			$retOrang = explode(' ', $ret);
			$retOrang = array_map('trim', $retOrang);
			
			//print_r($retOrang);
			
			foreach($retOrang as $item){
				$retOrang1 = explode('@', $item);
				$retOrang2 = array_map('trim', $retOrang1);
				//print_r($retOrang2);
				
				if ($retOrang2[0] === '' && isset($retOrang2[1])){
				$enc = URI::ReturnURI('App=Account&Com=Profile&Act=Detail&UName='.Encryption::Encrypt($retOrang2[1]));
				$ret = str_replace($item, '<a href="'.$enc.'">'.$retOrang2[1].'</a>', $ret);
				}
			}
			
			//$ret = preg_replace('/(^|\s)@(\w+)/', '\1<span class="hover_orang" rel="\2"><a href="'.URI::ReturnURI('App=Account&Com=Profile&Act=Detail&UName=\2').'" >\2</a></span>', $ret);
			
			//$ret = preg_replace('/(^|\s)#(\w+)/', '\1#<a href="http://localhost/tempHTML3/index.php#\2">\2</a>', $ret);
			$ret = nl2br(strip_tags($ret,'<span><a><img><p><div>'));
			$ret = str_replace(array(chr(10),chr(13)),'',$ret);
            
			return $ret;
 	}
	
}

?>