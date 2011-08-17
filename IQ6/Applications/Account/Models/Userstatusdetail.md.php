<?php

Import::Entity('Account.Userstatusdetail');
Import::Model('Account.User');
Import::Model('Account.Userstatusdetaillike');

class Userstatusdetail extends Model{
	
	public function __construct() {
        parent::__construct();
        $this->tableName = 'userstatusdetail';
        $this->lastTable = 'userstatusdetail';
        $this->application = 'Account';
    }	
    
	function LastId(){
    	$q = $this->OrderBy('USDID', 'desc')->First();
    	return $q->USDID;
    }
    
	function AmbilTime($USDID){
    	$q = $this->Equal('USDID', $USDID)->OrderBy('USDID', 'desc')->First();
    	return $q->USDTimeCreate;
    }
	
	function DeleteComment_WithParent($IdStatus){
    	$Comment = $this->Equal('USID', $IdStatus)->First();    	
		$this->Delete($Comment);
    }
    
	function DeleteComment_WithOutParent(Input $Input){
		//$IdComment = $Input->Post('IdStatus');
    	//$Comment = $this->Equal('USDID', $IdComment)->First();    	
		//$this->Delete($Comment);
		
		$IdComment = $Input->Post('IdStatus');
        
        Database::Instance()->ExecuteQuery("
        delete from userstatusdetail where USDID = '.$IdComment.'
        ");
		
    }
    
	function ShareStatus(Input $Input){
 		$DataStatus = new UserstatusdetailEntity();
 		$DataStatus->UName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
 		$DataStatus->USID = $Input->Post('StatusId');
 		$DataStatus->USDType = 'Comment';
 		$DataStatus->USDStatusComment = $Input->Post('commentStatus', XSS);
 		
 		$this->Add($DataStatus);
 		
 		$lastId = $this->LastId();
 		
 		//$dt = time();
 		
 		$dt = $this->AmbilTime($lastId);
 		
 		$_dt = date('j M Y G:i:s', strtotime($dt));
 		
 		if (is_string($dt)){
			$dt=strtotime($dt);
		}
		
		$dt = $this->relativeTime($dt);
		
		$UserSignIn = new User();
		
		Database::Instance()->SetConfig("localhost", "mastertables");
        Database::Instance()->Connect();
		
		$DataUser = ($UserSignIn->GetBasicInformation2($DataStatus->UName));
		
		$Nama = $DataUser->FirstName.' '.$DataUser->LastName;
		
		$Status = $Input->Post('commentStatus', XSS);
		
		$AvatarFilePath = $DataUser->AvatarFilePath;
    	if (!$AvatarFilePath) $AvatarFilePath = '';
		
    	if (!$AvatarFilePath){ 
            $Avatar = '<img src="'.Path::Template('Images/thumb1.jpg').'" width="32" height="32" />';
    	}else{
    		$Avatar = '<img src="'.Config::Instance('default')->photos.'p_small_'.$AvatarFilePath.'.jpg" width="32" height="32" />';
    	}
    	
    	$lastId = $this->LastId();
    	
    			$URL = URI::ReturnURI('App=Account&Com=Profile');
    			if ($DataUser->UName !== $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
    			$URL = URI::ReturnURI('App=Account&Com=Profile&Act=Detail&UName='.Encryption::Encrypt($item->UName));
    			}
    			
    			$ProfileUrl = '
    			title="'.$Nama.'" href="'.$URL.'"
    			';
    	
    			/*
    			 * <span class="Separator">|</span>
                        <a href="" class="DeleteStatus" id="DeleteStatus" rel="Comment">Delete</a>
    			 */
    			
 		$return = array(
 			'status' => 1,
 			'html' => '
 			<li id="'.$lastId.'">
	        	<span class="profilePicture">
	            	'.$Avatar.'
	            </span>
	            <a class="delete DeleteStatus" title="Delete comment" id="DeleteStatus" rel="Comment"></a>
	            <span class="commentInfo">
	           		<span class="commentContent"><a class="title" '.$ProfileUrl.'>'.$Nama.'</a>'.($this->convert_url($Status)).'</span>
	                <span class="commentAction">
	                	<span class="commentTime" id="timestatuscomment" data-timestatus="'.$_dt.'">'.$dt.'</span>
	                    <span class="separator">.</span>
	                    <a href="" class="Like likeComment" id="likeComment">Like</a>
	                    <span class="separator">.</span>
	                   	<span class="commentTime countlike"></span>
	                   	
	              	</span>
	     		</span>
	            <div class="ClearFix"></div>
	        </li>
 			'
  		);
  		
  		
  		/* notificationcomment */
  		
  		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
    	$stmt = Database::Instance()->ExecuteQuery("
	       select * from
	       notificationcomment
	       where 
	       NUSDID = '".$DataStatus->USID."' and
	       NAuthor = '".$DataStatus->UName."'
	       limit 1
	        ");
    	
    	$result = Database::Instance()->Fetch($stmt);
    	
    	$c = count($result);
    	
    	if (!$c){
    		
    		$stmt = Database::Instance()->ExecuteQuery("
		       select * from
		       notificationcomment
		       where 
		       NUSDID = '".$DataStatus->USID."'
		       limit 1
		        ");
    		
    		$a = $DataStatus->UName .'=0;';
    		Database::Instance()->ExecuteQuery("
		       insert into notificationcomment set
				NArrUName = '".$a."',
				NUSDID = '".$DataStatus->USID."' ,
	      		NAuthor = '".$DataStatus->UName."'
	        ");
	    	
	    	$result = Database::Instance()->Fetch($stmt);
	    	
	    	$ArrUName = $result[0]->NArrUName;
    		
    		if ($ArrUName){
    		$re = $ArrUName;
    		$ea = explode(';', $re);
			$ea = array_map('trim', $ea);
    		}
    		
			$a = $DataStatus->UName.'=0;';
			
			if ($ArrUName){
			foreach($ea as $r){
				$ea1 = explode('=', $r);
				$ea1 = array_map('trim', $ea1);
				$UN = $ea1[0];
				if ($r && $UN != $DataStatus->UName){
				$a .= $UN.'=1;';
				}
			}
			}
			
			Database::Instance()->ExecuteQuery("
		       update notificationcomment set
				NArrUName = '".$a."'
				where
				NUSDID = '".$DataStatus->USID."'
	        ");
    		
    	}else{
    	
    		$ArrUName = $result[0]->NArrUName;
    		
    		$a = $DataStatus->UName.'=0;';
    		
    		if ($ArrUName){
    		$re = $ArrUName;
    		$ea = explode(';', $re);
			$ea = array_map('trim', $ea);

			foreach($ea as $r){
				$ea1 = explode('=', $r);
				$ea1 = array_map('trim', $ea1);
				$UN = $ea1[0];
				if ($r && $UN != $DataStatus->UName){
				$a .= $UN.'=1;';
				}
			}
			}
			
			Database::Instance()->ExecuteQuery("
		       update notificationcomment set
				NArrUName = '".$a."'
				where
				NUSDID = '".$DataStatus->USID."'
	        ");
    		
    	
    	}
    	
 		return json_encode($return);
 		
 	} 
 	
 	function RealtimeTimeComment(Input $Input, $Id){
 		$q = $this
 				->Equal('USID', $Id)
 				->Get();
 		
 		$return = '';
 		
 		if (count($q)){
 		
 		$return = array();
 			
 		foreach($q as $item){
 			
 			$dt = $item->USDTimeCreate;
 		
	 		if (is_string($dt)){
				$dt=strtotime($dt);
			}
			
			$dt = $this->relativeTime($dt);
 			
 			$return[] = array($dt, $Id);
 			
 		}
 		
 		}
 		
 		return $return;
 				
 	}
 	
 	function RealtimeAmbilComment(Input $Input, $Id){
 		
 		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
    	$q = Database::Instance()->ExecuteQuery("
	       select * from
	       userstatusdetail
	       where
	       USDID > '".$Id."'
	        ");
    	
    	$result = Database::Instance()->Fetch($q);
 		
    	/*
 		$q = $this
 				->Equal('USDID', $Id)
 				->Get();
 		*/
    	
 		$return = '';
 		
 		if (count($q)){
 		 		
 		$__return = '';
 		
 		$USID = '';
 		
 		$USDID = '';
 			
 		foreach($result as $item){
 			
 			$USID = $item->USID;
 			
 			$USDID = $item->USDID;
 			
 			$UserSignIn = new User();
 			
 			$UserStatusLike = new Userstatusdetaillike();
		
			Database::Instance()->SetConfig("localhost", "mastertables");
	        Database::Instance()->Connect();
			
			$DataUser = ($UserSignIn->GetBasicInformation2($item->UName));
			
			$Nama = $DataUser->FirstName.' '.$DataUser->LastName;
			
	 		$Status = $item->USDStatusComment;
			
			$AvatarFilePath = $DataUser->AvatarFilePath;
	    	if (!$AvatarFilePath) $AvatarFilePath = '';
			
	    	if (!$AvatarFilePath){ 
	            $Avatar = '<img src="'.Path::Template('Images/thumb1.jpg').'" width="32" height="32" />';
	    	}else{
	    		$Avatar = '<img src="'.Config::Instance('default')->photos.'p_small_'.$AvatarFilePath.'.jpg" width="32" height="32" />';
	    	}
	    	
	    	$dt = $item->USDTimeCreate;
 		
	    	$_dt = date('j M Y G:i:s', strtotime($dt));
	    	
	 		if (is_string($dt)){
				$dt=strtotime($dt);
			}
			
			$dt = $this->relativeTime($dt);
			
			$likes = $UserStatusLike->GetLikeStatus($item->USDID, $Input);
			
			$countlikecomment = $UserStatusLike->CekLikeComment($item->USDID);
			
			$DetailLikes = '';
			$LikeText = 'Like';
			if ($likes){
				$LikeText = 'Unlike';
			}
			
			if ($countlikecomment)
			$DetailLikes = '<span class="commentTime" id="countercomment">'.$countlikecomment.'</span>&nbsp;people like this.';
			
				$URL = URI::ReturnURI('App=Account&Com=Profile');
    			if ($item->UName !== $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
    			$URL = URI::ReturnURI('App=Account&Com=Profile&Act=Detail&UName='.Encryption::Encrypt($item->UName));
    			}
    			
    			$ProfileUrl = '
    			title="'.$Nama.'" href="'.$URL.'"
    			';
			
    			/*
    			 * <span class="Separator">|</span>
                        <a href="" class="DeleteStatus" id="DeleteStatus" rel="Comment">Delete</a>
    			 */
    			
			$return = 
			'
 			<li id="'.$item->USDID.'">
	        	<span class="profilePicture">
	            	'.$Avatar.'
	            </span>
	            <a class="delete DeleteStatus" title="Delete comment" id="DeleteStatus" rel="Comment"></a>
	            <span class="commentInfo">
	           		<span class="commentContent"><a class="title" '.$ProfileUrl.'>'.$Nama.'</a>'.($this->convert_url($Status)).'</span>
	                <span class="commentAction">
	                	<span class="commentTime" id="timestatuscomment" data-timestatus="'.$_dt.'">'.$dt.'</span>
	                    <span class="separator">.</span>
	                    <a href="" class="'.$LikeText.' likeComment" id="likeComment">'.$LikeText.'</a>
	                    <span class="separator">.</span>
	                   	<span class="commentTime countlike">'.$DetailLikes.'</span>
	                   	
	              	</span>
	     		</span>
	            <div class="ClearFix"></div>
	        </li>
 			';
			
 		}
 		
 		}
 		
 		return json_encode(array(
 			'status' => 1,
 			'html' => $return,
 			'USID' => $USID,
 			'LastComment' => $USDID
 		));		
 				
 	}
 	
	function RealtimeComment(Input $Input, $Id){
 		$q = $this
 				->Equal('USID', $Id)
 				->Get();
 		
 		$return = '';
 		
 		if (count($q)){
 		
 		$return = array();
 		
 		$__return = '';
 			
 		foreach($q as $item){
 			
 			$UserSignIn = new User();
 			
 			$UserStatusLike = new Userstatusdetaillike();
		
			Database::Instance()->SetConfig("localhost", "mastertables");
	        Database::Instance()->Connect();
			
			$DataUser = ($UserSignIn->GetBasicInformation2($item->UName));
			
			$Nama = $DataUser->FirstName.' '.$DataUser->LastName;
			
	 		$Status = $item->USDStatusComment;
			
			$AvatarFilePath = $DataUser->AvatarFilePath;
	    	if (!$AvatarFilePath) $AvatarFilePath = '';
			
	    	if (!$AvatarFilePath){ 
	            $Avatar = '<img src="'.Path::Template('Images/thumb1.jpg').'" width="32" height="32" />';
	    	}else{
	    		$Avatar = '<img src="'.Config::Instance('default')->photos.'p_small_'.$AvatarFilePath.'.jpg" width="32" height="32" />';
	    	}
	    	
	    	$dt = $item->USDTimeCreate;
 		
	 		if (is_string($dt)){
				$dt=strtotime($dt);
			}
			
			$dt = $this->relativeTime($dt);
			
			$likes = $UserStatusLike->GetLikeStatus($item->USDID, $Input);
			
			$countlikecomment = $UserStatusLike->CekLikeComment($item->USDID);
			
			$DetailLikes = '';
			$LikeText = 'Like';
			if ($likes){
				$LikeText = 'Unlike';
			}
			
			if ($countlikecomment)
			$DetailLikes = '<span class="commentTime" id="countercomment">'.$countlikecomment.'</span>&nbsp;people like this.';
			
				$URL = URI::ReturnURI('App=Account&Com=Profile');
    			if ($item->UName !== $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
    			$URL = URI::ReturnURI('App=Account&Com=Profile&Act=Detail&UName='.Encryption::Encrypt($item->UName));
    			}
    			
    			$ProfileUrl = '
    			title="'.$Nama.'" href="'.$URL.'"
    			';
			
    			/*
    			 * <span class="Separator">|</span>
                        <a href="" class="DeleteStatus" id="DeleteStatus" rel="Comment">Delete</a>
    			 */
    			
			$__return = 
			'
 			<li id="'.$item->USDID.'">
	        	<span class="profilePicture">
	            	'.$Avatar.'
	            </span>
	            <a class="delete DeleteStatus" title="Delete comment" id="DeleteStatus" rel="Comment"></a>
	            <span class="commentInfo">
	           		<span class="commentContent"><a class="title" '.$ProfileUrl.'>'.$Nama.'</a>'.($this->convert_url($Status)).'</span>
	                <span class="commentAction">
	                	<span class="commentTime" id="commentTime">'.$dt.'</span>
	                    <span class="separator">.</span>
	                    <a href="" class="'.$LikeText.' likeComment" id="likeComment">'.$LikeText.'</a>
	                    <span class="separator">.</span>
	                   	<span class="commentTime countlike">'.$DetailLikes.'</span>
	                   	
	              	</span>
	     		</span>
	            <div class="ClearFix"></div>
	        </li>
 			';
 			
			$return[] = array($__return, $Id, $item->USDID, count($q));
			
 		}
 		
 		}
 		
 		return $return;
 				
 	}
 	
 	function AmbilUserComment(Input $Input, $Id){
 		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
    	$stmt = Database::Instance()->ExecuteQuery("
    	select 
    	distinct
    	UName
    	from userstatusdetail
    	where USID = '".$Id."'
    	");
    	
    	$q = Database::Instance()->Fetch($stmt);
 		$return = '';
 		
 		if (count($q)){
 			$i = 0;
 			$c = count($q);
 			foreach($q as $item){
 				if ($i > 1) break;
 				if ($i == $c-1 && $c > 1) $return .= ' and ';
 				$user = $item->UName;
 				if ($user == $Input->Session('EDU')->GetValue('EDU_TOKENUNAME'))
 					$user = 'You';
 					
 				$return .= $user;
 				
 				if ($i != $c-1) $return .= ', ';
 				$i++;
 			}
 			
 			if ($c > 2) $return .= ' and '.($c-$i).' peoples ';
 			
 			$return .= ' comment this one.';
 			
 		}
 		
 		return $return;
 		
 	}
 	
 	function GetComment(Input $Input, $Id){
 		$q = $this
 				->Equal('USID', $Id)
 				->Get();
 		$return = '';
 		
 		if (count($q)){
 		
 			$jml = count($q);
 			$i = 0;
 			
 			if ($jml > 3) {
 			$current_jml = $jml - 3;
 			$return = '
 			<li id="FetchingComment" class="FetchingComment">
	        	<a href="#">('.$current_jml.') Show Comment...</a>
	            <div class="ClearFix"></div>
	        </li>
 			';
 			}
 			
 		foreach($q as $item){
 			$UserSignIn = new User();
 			
 			$UserStatusLike = new Userstatusdetaillike();
		
			Database::Instance()->SetConfig("localhost", "mastertables");
	        Database::Instance()->Connect();
			
			$DataUser = ($UserSignIn->GetBasicInformation2($item->UName));
			
			$Nama = $DataUser->FirstName.' '.$DataUser->LastName;
			
	 		$Status = $item->USDStatusComment;
			
			$AvatarFilePath = $DataUser->AvatarFilePath;
	    	if (!$AvatarFilePath) $AvatarFilePath = '';
			
	    	if (!$AvatarFilePath){ 
	            $Avatar = '<img src="'.Path::Template('Images/thumb1.jpg').'" width="32" height="32" />';
	    	}else{
	    		$Avatar = '<img src="'.Config::Instance('default')->photos.'p_small_'.$AvatarFilePath.'.jpg" width="32" height="32" />';
	    	}
	    	
	    	$dt = $item->USDTimeCreate;
 		
	    	$_dt = date('j M Y G:i:s', strtotime($dt));
	    	
	 		if (is_string($dt)){
				$dt=strtotime($dt);
			}
			
			$dt = $this->relativeTime($dt);
			
			$likes = $UserStatusLike->GetLikeStatus($item->USDID, $Input);
			
			$countlikecomment = $UserStatusLike->CekLikeComment($item->USDID);
			
			$DetailLikes = '';
			$LikeText = 'Like';
			if ($likes){
				$LikeText = 'Unlike';
			}
			
			if ($countlikecomment)
			$DetailLikes = '<span class="commentTime" id="countercomment">'.$countlikecomment.'</span>&nbsp;people like this.';
			
			++$i;
			
			$beda = $jml - $i;
			
			$style = 'display:block;';
			if ($jml > 3) $style = 'display:none;';
			if ($beda < 3 && $jml > 3) $style = 'display:block;';
			
				$URL = URI::ReturnURI('App=Account&Com=Profile');
    			if ($item->UName !== $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
    			$URL = URI::ReturnURI('App=Account&Com=Profile&Act=Detail&UName='.Encryption::Encrypt($item->UName));
    			}
    			
    			$ProfileUrl = '
    			title="'.$Nama.'" href="'.$URL.'"
    			';
			
    			
    			/*
    			 * <span class="Separator">|</span>
                        <a href="" class="DeleteStatus" id="DeleteStatus" rel="Comment">Delete</a>
    			 */
    			
			$return .= 
			'
 			<li id="'.$item->USDID.'" style="'.$style.'">
	        	<span class="profilePicture">
	            	'.$Avatar.'
	            </span>
	            <a class="delete DeleteStatus" title="Delete comment" id="DeleteStatus" rel="Comment"></a>
	            <span class="commentInfo">
	           		<span class="commentContent"><a class="title" '.$ProfileUrl.'>'.$Nama.'</a>'.($this->convert_url($Status)).'</span>
	                <span class="commentAction">
	                	<span class="commentTime" id="timestatuscomment" data-timestatus="'.$_dt.'">'.$dt.'</span>
	                    <span class="separator">.</span>
	                    <a href="" class="'.$LikeText.' likeComment" id="likeComment">'.$LikeText.'</a>
	                    <span class="separator">.</span>
	                   	<span class="commentTime countlike">'.$DetailLikes.'</span>
	                   	
	              	</span>
	     		</span>
	            <div class="ClearFix"></div>
	        </li>
 			';
			
 		}
 		
 		}
 		
 		return $return;
 		
 	}
 	
	function test(){return 'aaa';}
 	
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
 	
	function relativeTime($dt,$koma=2){
		$times=array(
			365*24*60*60=>"year",
			30*24*60*60=>"month",
			7*24*60*60=>"week",
			24*60*60=>"day",
			60*60=>"hour",
			60=>"minute",
			1=>"second"
		);
		$passed=time()-$dt;
		if ($passed<3){
			$output='Just Now';
		}else
		if ($passed<5){
			$output='Less Than 5 Seconds Ago';
		}else{
			$output=array();
			$exit=0;
			foreach($times as $period=>$name){
				if ($exit>=$koma || ($exit>0 && $period<60)) break;
				$result=floor($passed/$period);
				if ($result>0){
					$output[]=$result.' '.$name.($result==1?'':'s');
					$passed-=$result*$period;
					$exit++;
				}else if ($exit>0){
					$exit++;
				}
			}
			$output=implode(' and ',$output).' ago';
		}
		return $output;
	}
    
}

?>