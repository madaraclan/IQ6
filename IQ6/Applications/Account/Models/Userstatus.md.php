<?php

Import::Model('Account.User');
Import::Model('Account.Userstatuslikes');
Import::Model('Account.Userstatusdetail');
Import::Model('Account.Userfriend');
Import::Entity('Account.Userstatus');
Import::Entity('Account.TempClass');

class Userstatus extends Model{
	
	public $TempOutput;
	
	public function __construct() {
        parent::__construct('localhost', 'socialnetwork');
        $this->tableName = 'userstatus';
        $this->lastTable = 'userstatus';
        $this->application = 'Account';
    }	
    
    function LastId(){
    	$q = $this->OrderBy('USID', 'desc')->First();
    	return $q->USID;
    }
    
	function AmbilTime($USID){
    	$q = $this->Equal('USID', $USID)->OrderBy('USID', 'desc')->First();
    	return $q->USTime;
    }
    
    function RealtimeJmlNotif($Input){
    	
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
    		
    		return $jmlnotif;
    	
    }
    
    function AmbilNotifStatus(Input $Input, $USID, $VA){
    	
    	//echo $USID.'->3';
    	
    	Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
    	$stmt = Database::Instance()->ExecuteQuery("
    	select 
    	userstatus.*,
		user.FirstName,
		user.LastName,
		user.AvatarFilePath
    	from userstatus 
    	join user on(
    	user.UName = userstatus.UName
    	)
    	where
    	userstatus.USID = '".$USID."' limit 1
    	");
    	
    	$q = Database::Instance()->Fetch($stmt);
    	
    	/*
    	$q = $this
    			  ->Equal('USID', $USID)
    			  ->Equal('User.UName', $Input->Session('EDU')->GetValue('EDU_TOKENUNAME'))
 				  ->In('User.UName', "
                        SELECT UFRName FROM userfriend
                        WHERE UName = '".$Input->Session('EDU')->GetValue('EDU_TOKENUNAME')."' and
                        Muted = 0
                    ", "OR")
                  ->OrderBy('USID', 'desc')
                  ->Join('User')
 				  ->Get();
    	*/
    	
    	$item = $q[0];
    	
    	$jml = count($q);
    	
    	$return = '';
    	
    	if ($jml){
    		
    		$UserSignIn = new User();
	 		$UserStatusLike = new Userstatuslikes();
	 		$Comment = new Userstatusdetail();
			    		
    			$Nama = $item->FirstName.' '.$item->LastName;
				
				$Status = $item->USStatus;
				
				$Emoticon = $item->Mood;
				
				$dt = $item->USTime;
 		
				$_dt = date('j M Y G:i:s', strtotime($dt));
				
		 		if (is_string($dt)){
					$dt=strtotime($dt);
				}
				
				$passed = $dt;
				
				$dt = $this->relativeTime($dt);
				
				
				
				$AvatarFilePath = $item->AvatarFilePath;
		    	if (!$AvatarFilePath) $AvatarFilePath = '';
				
		    	if (!$AvatarFilePath){ 
		            $Avatar = '<img src="'.Path::Template('Images/thumb1.jpg').'" />';
		    	}else{
		    		$Avatar = '<img src="'.Config::Instance('default')->photos.'p_small_'.$AvatarFilePath.'.jpg" />';
		    	}
		    	
		    	$likes = $UserStatusLike->GetLikeStatus($item->USID, $Input);
		    	
		    	$DetailComment = $Comment->GetComment($Input, $item->USID);
		    	$UserComment = $Comment->AmbilUserComment($Input, $item->USID);
		    	
		    	$tmplComment = '
		    	<span class="arrow"></span>
	                <div class="ClearFix"></div>
	                 	<ul class="listReply" id="listReply">
		    	';
		    	
		    	$DetailLikes = '';
		    	$Buttonlike = 'Like';
		    	
		    	if ($likes || $DetailComment){
		    	
		    	$DetailLikes .= $tmplComment;
		    	
		    	if ($likes){
		    		$DetailLikes = $tmplComment.'
	                 		<li class="LikeContainer"><span class="iconLikeComment iconLike"></span><span style="font-size:11px;">'.$likes.'</span> like this.</li>
	                 		'.$DetailComment;
		    		if ($UserStatusLike->YouLike)
		    		$Buttonlike = 'Unlike';
		    	}else{
		    		$DetailLikes .= $DetailComment;
		    	}
		    	
		   		$DetailLikes .= '</ul><div>';
		    	
		    	}
		    	
		    	$Muted = '';
    	if ($item->UName !== $Input->Session('EDU')->GetValue('EDU_TOKENUNAME'))
    	$Muted = '<a class="Icon13 iconMute13" rel="'.$item->UName.'" id="Muted"></a>';
		    	
    			//$p = json_decode($this->TempOutput);
    			//$p1 = $p[0];
    			//$p2 = $p[1];
    	
    			$Delete = '';
    			if ($item->UName === $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
    	
    			$Delete = '
    			<span class="Separator">|</span>
               	<a href="" class="DeleteStatus" id="DeleteStatus" rel="Status">Delete</a>
    			';
    			
    			}
    			
    			$URL = URI::ReturnURI('App=Account&Com=Profile');
    			if ($item->UName !== $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
    			$URL = URI::ReturnURI('App=Account&Com=Profile&Act=Detail&UName='.Encryption::Encrypt($item->UName));
    			}
    			
    			$ProfileUrl = '
    			title="'.$Nama.'" href="'.$URL.'"
    			';
    			
    			$Notif = '- <span>Old Notif</span>';
    			if ($VA == 1) $Notif = '- <span style="color:red;">NEW NOTIF</span>';
    			
 				$return = '
 					<li id="'.$item->USID.'">
 						<div class="dtinfo" style="margin-bottom:20px;display:block;cursor:pointer;">'.$Notif.' -> '.$VA.' '.$USID.' ->>>>> '.$UserComment.' </div>
                        <div class="dtdetail" style="display:none;">
 						<span class="DisplayPicture">'.$Avatar.'</span>
                        <div class="DisplayInformation">
                            <a class="PeopleName" '.$ProfileUrl.'>'.$Nama.' </a>
                            '.$Muted.'
                            <span class="ShareContent">'.($this->convert_url($Status)).'</span>
                            <span class="hrLineSplitter"></span>
                            <span class="DetailInfoShareContent">
                                <span class="ShareTimeInformation" id="timestatus" data-timestatus="'.$_dt.'">'.$dt.'</span>
                                <span class="Separator">|</span>
                                <a href="" class="LinkInfo '.$Buttonlike.'" id="Like">'.$Buttonlike.'</a>
                                <span class="Separator">|</span>
                                <a href="" class="LinkInfo Comment" id="Comment">Comment</a>
                                '.$Delete.'
                                <span class="ClearFix"></span>
                            </span>
                            <span class="moodContainer">
                                <span title="'.$Emoticon.'" class="iconMoods '.$Emoticon.'"></span>
                            </span>

                            <div class="ClearFix"></div>

                            <!--For Comment and Like Box-->
                            <div class="boxCommentLike" id="boxCommentLike">
								'.$DetailLikes.'
                            </div>
                        </div>
                        </div>
                    </li>
 				';
 				 				
 			}
 			
 			
 			return $return;
    	
    }
    
    function Notif($Input){
    	
   		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
    	$stmt = Database::Instance()->ExecuteQuery("
    	select * from notificationcomment
    	where
    	NAuthor = '".$Input->Session('EDU')->GetValue('EDU_TOKENUNAME')."'
    	order by dt desc
    	limit 6
    	");
    		
    		$result = Database::Instance()->Fetch($stmt);
    		    		
    		$jmlnotif  = 0;
    		
    		$return = '';
    		
    		foreach($result as $res){
    			
	    		$ArrUName = $res->NArrUName;
	    		$USID = $res->NUSDID;
	    			    		
	    		if ($ArrUName){
	    		$re = $ArrUName;
	    		$ea = explode(';', $re);
				$ea = array_map('trim', $ea);
				
				//echo $USID.'->1';
				foreach($ea as $r){
					
					if ($r){
					
					$ea1 = explode('=', $r);
					$ea1 = array_map('trim', $ea1);
					$UN = $ea1[0];
					$VA = $ea1[1];
										
					if ($r 
					&& $UN == $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')
					//&& $VA == 1
					){
						//$jmlnotif++;
						//echo $USID.'->2';
						$return .= $this->AmbilNotifStatus($Input, $USID, $VA);
						
					}
					
					
					}
					
				}
				
	    		}
    			
    		}
    		
    		return $return;
    	
    }
    
    function DeleteUserStatus(Input $Input){
    	//$IdStatus = $Input->Post('IdStatus');
    	//$Status = $this->Equal('USID', $IdStatus)->First();
    	//$this->Delete($Status);
    	
    	//$Comment = new Userstatusdetail();
    	//$Comment->DeleteComment_WithParent($IdStatus);
    	
    	
    	$IdStatus = $Input->Post('IdStatus');
        
        Database::Instance()->ExecuteQuery("
        delete from userstatus where USID = '.$IdStatus.'
        ");
                
        Database::Instance()->ExecuteQuery("
        delete from userstatusdetail where USID = '.$IdStatus.'
        ");
    	
    }
    
    
	
 	function ShareStatus(Input $Input){
 		$DataStatus = new UserstatusEntity();
 		$DataStatus->UName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
 		$DataStatus->Mood = $Input->Post('Emoticon');
 		$DataStatus->USStatus = $Input->Post('Status', XSS);
 		$DataStatus->USStatus .= $Input->Post('Attachment', false);
 		
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
		
		$DataUser = ($UserSignIn->GetBasicInformation($Input));
		
		$Nama = $DataUser->FirstName.' '.$DataUser->LastName;
		
		$Status = $Input->Post('Status', XSS);
		$Status .= $Input->Post('Attachment', false);
		
		$Emoticon = $Input->Post('Emoticon');
		
		$AvatarFilePath = $DataUser->AvatarFilePath;
    	if (!$AvatarFilePath) $AvatarFilePath = '';
		
    	if (!$AvatarFilePath){ 
            $Avatar = '<img src="'.Path::Template('Images/thumb1.jpg').'" />';
    	}else{
    		$Avatar = '<img src="'.Config::Instance('default')->photos.'p_small_'.$AvatarFilePath.'.jpg" />';
    	}
    	
    	
    	
    	$Muted = '';
    	if ($DataUser->UName !== $Input->Session('EDU')->GetValue('EDU_TOKENUNAME'))
    	$Muted = '<a class="Icon13 iconMute13" rel="'.$DataUser->UName.'" id="Muted"></a>';
    	
 				$Delete = '';
    			if ($DataUser->UName === $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
    	
    			$Delete = '
    			<span class="Separator">|</span>
               	<a href="" class="DeleteStatus" id="DeleteStatus" rel="Status">Delete</a>
    			';
    			
    			}
    			
    			
    			$URL = URI::ReturnURI('App=Account&Com=Profile');
    			if ($DataUser->UName !== $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
    			$URL = URI::ReturnURI('App=Account&Com=Profile&Act=Detail&UName='.Encryption::Encrypt($DataUser->UName));
    			}
    			
    			$ProfileUrl = '
    			title="'.$Nama.'" href="'.$URL.'"
    			';
    	
 		$return = array(
 			'status' => 1,
 			'html' => '
 					<li id="'.$lastId.'">
                        <span class="DisplayPicture">'.$Avatar.'</span>
                        <div class="DisplayInformation">
                            <a class="PeopleName" '.$ProfileUrl.'>'.$Nama.'</a>
                            '.$Muted.'
                            <span class="ShareContent">'.($this->convert_url($Status)).'</span>
                            <span class="hrLineSplitter"></span>
                            <span class="DetailInfoShareContent">
                                <span class="ShareTimeInformation" id="timestatus" data-timestatus="'.$_dt.'">'.$dt.'</span>
                                <span class="Separator">|</span>
                                <a href="" class="LinkInfo Like" id="Like">Like</a>
                                <span class="Separator">|</span>
                                <a href="" class="LinkInfo Comment" id="Comment">Comment</a>
                                '.$Delete.'
                                <span class="ClearFix"></span>
                            </span>
                            <span class="moodContainer">
                                <span title="'.$Emoticon.'" class="iconMoods '.$Emoticon.'"></span>
                            </span>

                            <div class="ClearFix"></div>

                            <!--For Comment and Like Box-->
                            <div class="boxCommentLike" id="boxCommentLike">
                               
                            </div>
                        </div>
                    </li>
 			'
  		);
  		
  		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
    	$stmt = Database::Instance()->ExecuteQuery("
	    insert into notificationcomment set
	    NAuthor = '".$DataStatus->UName."',
	    NUSDID = '".$lastId."',
	    NArrUName = '".$DataStatus->UName."=0'
	    ");
 		
 		return json_encode($return);
 		
 	}
 	
 	function RealTimeGetTime(Input $Input){
 		
 		$q = $this->Equal('User.UName', $Input->Session('EDU')->GetValue('EDU_TOKENUNAME'))
 				  ->In('User.UName', "
                        SELECT UFRName FROM userfriend
                        WHERE UName = '".$Input->Session('EDU')->GetValue('EDU_TOKENUNAME')."' and
                        Muted = 0
                    ", "OR")
                  ->OrderBy('USID', 'desc')
                  ->Join('User')
 				  ->Get();

 		$jml = count($q);
 		
 		$return = '';
 		
 		$Comment = new Userstatusdetail();
 		
 		if ($jml){
 		
 			$return = array();
 			$returnCommentTime = array();
 			$returnComment = array();
 			$i = 0; 
 		foreach($q as $item){

 				$dt = $item->USTime;
 		
		 		if (is_string($dt)){
					$dt=strtotime($dt);
				}
				
				$dt = $this->relativeTime($dt);
				
 		
 			
 			$DetailComment = $Comment->RealtimeTimeComment($Input, $item->USID);

 			$DetailGetComment = $Comment->RealtimeComment($Input, $item->USID);
 			
 			$return[] = $dt;
 			
 			$returnCommentTime[] = $DetailComment;
 			
 			$returnComment[] = $DetailGetComment;
 			
 			$i++;
 			
 		}
 		
 		}
 		
 		return json_encode(array(
 			'waktu' => $return, 
 			'waktuCommentTime' => $returnCommentTime,
 			'comment' => $returnComment
 		));
 		
 	}
 	
 	function RealTimeGetStatus(Input $Input, $LastId){
 		
 		$q = $this->Equal('User.UName', $Input->Session('EDU')->GetValue('EDU_TOKENUNAME'))
 				  ->MoreThan('USID', $LastId)
 					->In('User.UName', "
                        SELECT UFRName FROM userfriend
                        WHERE UName = '".$Input->Session('EDU')->GetValue('EDU_TOKENUNAME')."'
                    ", "OR")
                  ->OrderBy('USID', 'desc')
                  ->Join('User')
 				  ->Get();
 		
 		$jml = count($q);
 		
 		$return = '';
 		
 		$UserSignIn = new User();
 		$UserStatusLike = new Userstatuslikes();
 		$Comment = new Userstatusdetail();
		
		Database::Instance()->SetConfig("localhost", "mastertables");
        Database::Instance()->Connect();
		
		$DataUser = ($UserSignIn->GetBasicInformation($Input));
 		
		$AwalID = $q[0]->USID;
		
 		if ($jml){
 			foreach($q as $item){

 				if ($item->USID > $LastId && $item->UName != $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
 					
 				$Nama = $item->FirstName.' '.$item->LastName;
				
				$Status = $item->USStatus;
				
				$Emoticon = $item->Mood;
				
				$dt = $item->USTime;
 		
				$_dt = date('j M Y G:i:s', strtotime($dt));
				
		 		if (is_string($dt)){
					$dt=strtotime($dt);
				}
				
				$dt = $this->relativeTime($dt);
				
				$AvatarFilePath = $item->AvatarFilePath;
		    	if (!$AvatarFilePath) $AvatarFilePath = '';
				
		    	if (!$AvatarFilePath){ 
		            $Avatar = '<img src="'.Path::Template('Images/thumb1.jpg').'" />';
		    	}else{
		    		$Avatar = '<img src="'.Config::Instance('default')->photos.'p_small_'.$AvatarFilePath.'.jpg" />';
		    	}
		    	
		    	$likes = $UserStatusLike->GetLikeStatus($item->USID, $Input);
		    	
		    	$DetailComment = $Comment->GetComment($Input, $item->USID);
		    	
		    	$tmplComment = '
		    	<span class="arrow"></span>
	                <div class="ClearFix"></div>
	                 	<ul class="listReply" id="listReply">
		    	';
		    	
		    	$DetailLikes = '';
		    	$Buttonlike = 'Like';
		    	
		    	if ($likes || $DetailComment){
		    	
		    	$DetailLikes .= $tmplComment;
		    	
		    	if ($likes){
		    		$DetailLikes = $tmplComment.'
	                 		<li class="LikeContainer"><span class="iconLikeComment iconLike"></span><span style="font-size:11px;">'.$likes.'</span> like this.</li>
	                 		'.$DetailComment;
		    		if ($UserStatusLike->YouLike)
		    		$Buttonlike = 'Unlike';
		    	}else{
		    		$DetailLikes .= $DetailComment;
		    	}
		    	
		   		$DetailLikes .= '</ul><div>';
		    	
		    	}
		    	
		    	$Muted = '';
    	if ($item->UName !== $Input->Session('EDU')->GetValue('EDU_TOKENUNAME'))
    	$Muted = '<a class="Icon13 iconMute13" rel="'.$item->UName.'" id="Muted"></a>';
		    	
 				$Delete = '';
    			if ($item->UName === $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
    	
    			$Delete = '
    			<span class="Separator">|</span>
               	<a href="" class="DeleteStatus" id="DeleteStatus" rel="Status">Delete</a>
    			';
    			
    			}
    			
    			$URL = URI::ReturnURI('App=Account&Com=Profile');
    			if ($item->UName !== $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
    			$URL = URI::ReturnURI('App=Account&Com=Profile&Act=Detail&UName='.Encryption::Encrypt($item->UName));
    			}
    			
    			$ProfileUrl = '
    			title="'.$Nama.'" href="'.$URL.'"
    			';
    	
 				$return .= '
 					<li id="'.$item->USID.'">
                        <span class="DisplayPicture">'.$Avatar.'</span>
                        <div class="DisplayInformation">
                            <a class="PeopleName" '.$ProfileUrl.'>'.$Nama.'</a>
                            '.$Muted.'
                            <span class="ShareContent">'.($this->convert_url($Status)).'</span>
                            <span class="hrLineSplitter"></span>
                            <span class="DetailInfoShareContent">
                                <span class="ShareTimeInformation" id="timestatus" data-timestatus="'.$_dt.'">'.$dt.'</span>
                                <span class="Separator">|</span>
                                <a href="" class="LinkInfo '.$Buttonlike.'" id="Like">'.$Buttonlike.'</a>
                                <span class="Separator">|</span>
                                <a href="" class="LinkInfo Comment" id="Comment">Comment</a>
								'.$Delete.'
                                <span class="ClearFix"></span>
                            </span>
                            <span class="moodContainer">
                                <span title="'.$Emoticon.'" class="iconMoods '.$Emoticon.'"></span>
                            </span>

                            <div class="ClearFix"></div>

                            <!--For Comment and Like Box-->
                            <div class="boxCommentLike" id="boxCommentLike">
								'.$DetailLikes.'
                            </div>
                        </div>
                    </li>
 				';
 				
 				}
 				
 				
 			}
 		}else{
 			$return = '';
 		}
 		
 		
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
		$LastIdComment = $result[0]->USDID;
 		
 			return json_encode(array(
				'status' => 1,
				'html' => $return,
 				'jml' => $jml,
 				'AwalID' => $AwalID,
 				'LastComment' => $LastIdComment
			));
 				  
 	}
 	
 	function GetStatus(Input $Input, $start=0, $perpage = 15){
 		$Qtotal = $this
 					->Equal('UName', $Input->Session('EDU')->GetValue('EDU_TOKENUNAME'))
                    ->In('UName', "
                        SELECT UFRName FROM userfriend
                        WHERE 
                        UName = '".$Input->Session('EDU')->GetValue('EDU_TOKENUNAME')."' and
                        Muted = 0
                    ", "OR")
 					->Get();
 		
 		$jml = count($Qtotal);
        
        //$start = 0;
 		$q = $this->Equal('User.UName', $Input->Session('EDU')->GetValue('EDU_TOKENUNAME'))
 				  ->In('User.UName', "
                        SELECT UFRName FROM userfriend
                        WHERE UName = '".$Input->Session('EDU')->GetValue('EDU_TOKENUNAME')."' and
                        Muted = 0
                    ", "OR")
                  ->OrderBy('USID', 'desc')
                  ->Join('User')
 				  ->Limit($perpage, $start)
 				  ->Get();
 		
 		$return = '';
 		
// 		/echo $this->LastQuery();
 		
 		$UserSignIn = new User();
 		$UserStatusLike = new Userstatuslikes();
 		$Comment = new Userstatusdetail();
		
		Database::Instance()->SetConfig("localhost", "mastertables");
        Database::Instance()->Connect();
		
		$DataUser = ($UserSignIn->GetBasicInformation($Input));

 		if ($jml){
 			foreach($q as $item){

				$Nama = $item->FirstName.' '.$item->LastName;
				
				$Status = $item->USStatus;
				
				$Emoticon = $item->Mood;
				
				$dt = $item->USTime;
 		
				$_dt = date('j M Y G:i:s', strtotime($dt));
				
		 		if (is_string($dt)){
					$dt=strtotime($dt);
				}
				
				$passed = $dt;
				
				$dt = $this->relativeTime($dt);
				
				
				
				$AvatarFilePath = $item->AvatarFilePath;
		    	if (!$AvatarFilePath) $AvatarFilePath = '';
				
		    	if (!$AvatarFilePath){ 
		            $Avatar = '<img src="'.Path::Template('Images/thumb1.jpg').'" />';
		    	}else{
		    		$Avatar = '<img src="'.Config::Instance('default')->photos.'p_small_'.$AvatarFilePath.'.jpg" />';
		    	}
		    	
		    	$likes = $UserStatusLike->GetLikeStatus($item->USID, $Input);
		    	
		    	$DetailComment = $Comment->GetComment($Input, $item->USID);
		    	
		    	$tmplComment = '
		    	<span class="arrow"></span>
	                <div class="ClearFix"></div>
	                 	<ul class="listReply" id="listReply">
		    	';
		    	
		    	$DetailLikes = '';
		    	$Buttonlike = 'Like';
		    	
		    	if ($likes || $DetailComment){
		    	
		    	$DetailLikes .= $tmplComment;
		    	
		    	if ($likes){
		    		$DetailLikes = $tmplComment.'
	                 		<li class="LikeContainer"><span class="iconLikeComment iconLike"></span><span style="font-size:11px;">'.$likes.'</span> like this.</li>
	                 		'.$DetailComment;
		    		if ($UserStatusLike->YouLike)
		    		$Buttonlike = 'Unlike';
		    	}else{
		    		$DetailLikes .= $DetailComment;
		    	}
		    	
		   		$DetailLikes .= '</ul><div>';
		    	
		    	}
		    	
		    	$Muted = '';
    	if ($item->UName !== $Input->Session('EDU')->GetValue('EDU_TOKENUNAME'))
    	$Muted = '<a class="Icon13 iconMute13" rel="'.$item->UName.'" id="Muted"></a>';
		    	
    			//$p = json_decode($this->TempOutput);
    			//$p1 = $p[0];
    			//$p2 = $p[1];
    	
    			$Delete = '';
    			if ($item->UName === $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
    	
    			$Delete = '
    			<span class="Separator">|</span>
               	<a href="" class="DeleteStatus" id="DeleteStatus" rel="Status">Delete</a>
    			';
    			
    			}
    			
    			$URL = URI::ReturnURI('App=Account&Com=Profile');
    			if ($item->UName !== $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
    			$URL = URI::ReturnURI('App=Account&Com=Profile&Act=Detail&UName='.Encryption::Encrypt($item->UName));
    			}
    			
    			$ProfileUrl = '
    			title="'.$Nama.'" href="'.$URL.'"
    			';
    			
 				$return .= '
 					<li id="'.$item->USID.'">
                        <span class="DisplayPicture">'.$Avatar.'</span>
                        <div class="DisplayInformation">
                            <a class="PeopleName" '.$ProfileUrl.'>'.$Nama.'</a>
                            '.$Muted.'
                            <span class="ShareContent">'.($this->convert_url($Status)).'</span>
                            <span class="hrLineSplitter"></span>
                            <span class="DetailInfoShareContent">
                                <span class="ShareTimeInformation" id="timestatus" data-timestatus="'.$_dt.'">'.$dt.'</span>
                                <span class="Separator">|</span>
                                <a href="" class="LinkInfo '.$Buttonlike.'" id="Like">'.$Buttonlike.'</a>
                                <span class="Separator">|</span>
                                <a href="" class="LinkInfo Comment" id="Comment">Comment</a>
                                '.$Delete.'
                                <span class="ClearFix"></span>
                            </span>
                            <span class="moodContainer">
                                <span title="'.$Emoticon.'" class="iconMoods '.$Emoticon.'"></span>
                            </span>

                            <div class="ClearFix"></div>

                            <!--For Comment and Like Box-->
                            <div class="boxCommentLike" id="boxCommentLike">
								'.$DetailLikes.'
                            </div>
                        </div>
                    </li>
 				';
 				
 				$start++;
 				
 			}
 		}else{
 			$return = '<b>List Status not available.</b>';
 		}
 		
 		$nextStart = 0;
		if ($start < $jml) $nextStart = 1;
			
		
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
		$LastIdComment = $result[0]->USDID;
		
			return json_encode(array(
				'status' => 1,
				'html' => $return,
				'nextstart' => $nextStart,
				'start' => $start,
				'LastComment' => $LastIdComment
			));
 		
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
			$this->TempOutput = json_encode($output);
			$output=implode(' and ',$output).' ago';
		}
		return $output;
	}
	
	function GetStatusProfile(Input $Input, $start=0, $perpage = 15){
		
		$Qtotal = $this
 					->Equal('UName', $Input->Post('UName'))
 					->Get();
 		
 		$jml = count($Qtotal);
        
        //$start = 0;
 		$q = $this->Equal('User.UName', $Input->Post('UName'))
                  ->Join('User')
                  ->OrderBy('USID', 'desc')
 				  ->Limit($perpage, $start)
 				  ->Get();
 		
 		$return = '';
 		
// 		/echo $this->LastQuery();
 		
 		$UserSignIn = new User();
 		$UserStatusLike = new Userstatuslikes();
 		$Comment = new Userstatusdetail();
 		
 		
		
		Database::Instance()->SetConfig("localhost", "mastertables");
        Database::Instance()->Connect();
		
        
        
		
		
		$DataUser = ($UserSignIn->GetBasicInformation($Input));

 		if ($jml){
 			foreach($q as $item){
 				Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
		
        $Style = '';
        
        if ($item->UName !== $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
        
		$friend = new Userfriend();
 			$DataFollow = $friend->CekFollowFriend($Input, $item->UName);
    		$DataFollow_Type = 'Follow';
    		$DataFollow_TypeClass = 'buttonOrange';
    		$Style = 'style="display:none;"';
    		if ($DataFollow){
    			$DataFollow_Type = 'Un Follow';
    			$DataFollow_TypeClass = 'buttonGray';
    			$Style = '';
    		}
    		
        }

				$Nama = $item->FirstName.' '.$item->LastName;
				
				$Status = $item->USStatus;
				
				$Emoticon = $item->Mood;
				
				$dt = $item->USTime;
 		
				$_dt = date('j M Y G:i:s', strtotime($dt));
				
		 		if (is_string($dt)){
					$dt=strtotime($dt);
				}
				
				$passed = $dt;
				
				$dt = $this->relativeTime($dt);
				
				
				
				$AvatarFilePath = $item->AvatarFilePath;
		    	if (!$AvatarFilePath) $AvatarFilePath = '';
				
		    	if (!$AvatarFilePath){ 
		            $Avatar = '<img src="'.Path::Template('Images/thumb1.jpg').'" />';
		    	}else{
		    		$Avatar = '<img src="'.Config::Instance('default')->photos.'p_small_'.$AvatarFilePath.'.jpg" />';
		    	}
		    	
		    	$likes = $UserStatusLike->GetLikeStatus($item->USID, $Input);
		    	
		    	$DetailComment = $Comment->GetComment($Input, $item->USID);
		    	
		    	$tmplComment = '
		    	<span class="arrow"></span>
	                <div class="ClearFix"></div>
	                 	<ul class="listReply" id="listReply">
		    	';
		    	
		    	$DetailLikes = '';
		    	$Buttonlike = 'Like';
		    	
		    	if ($likes || $DetailComment){
		    	
		    	$DetailLikes .= $tmplComment;
		    	
		    	if ($likes){
		    		$DetailLikes = $tmplComment.'
	                 		<li class="LikeContainer"><span class="iconLikeComment iconLike"></span><span style="font-size:11px;">'.$likes.'</span> like this.</li>
	                 		'.$DetailComment;
		    		if ($UserStatusLike->YouLike)
		    		$Buttonlike = 'Unlike';
		    	}else{
		    		$DetailLikes .= $DetailComment;
		    	}
		    	
		   		$DetailLikes .= '</ul><div>';
		    	
		    	}
		    	
		    	$Muted = '';
    	if ($item->UName !== $Input->Session('EDU')->GetValue('EDU_TOKENUNAME'))
    	$Muted = '<a class="Icon13 iconMute13" rel="'.$item->UName.'" id="Muted"></a>';
		    	
    			//$p = json_decode($this->TempOutput);
    			//$p1 = $p[0];
    			//$p2 = $p[1];
    	
    			$Delete = '';
    			if ($item->UName === $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
    	
    			$Delete = '
    			<span class="Separator">|</span>
               	<a href="" class="DeleteStatus" id="DeleteStatus" rel="Status">Delete</a>
    			';
    			
    			}
    			
    			$URL = URI::ReturnURI('App=Account&Com=Profile');
    			if ($item->UName !== $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
    			$URL = URI::ReturnURI('App=Account&Com=Profile&Act=Detail&UName='.Encryption::Encrypt($item->UName));
    			}
    			
    			$ProfileUrl = '
    			title="'.$Nama.'" href="'.$URL.'"
    			';
    	
 				$return .= '
 					<li id="'.$item->USID.'">
                        <span class="DisplayPicture">'.$Avatar.'</span>
                        <div class="DisplayInformation">
                            <a class="PeopleName" '.$ProfileUrl.'>'.$Nama.'</a>
                            '.$Muted.'
                            <span class="ShareContent">'.($this->convert_url($Status)).'</span>
                            <span class="hrLineSplitter"></span>
                            <span class="DetailInfoShareContent">
                                <span class="ShareTimeInformation" id="timestatus" data-timestatus="'.$_dt.'">'.$dt.'</span>
                                <span class="Separator" '.$Style.'>|</span>
                                <a href="" class="LinkInfo '.$Buttonlike.'" id="Like" '.$Style.'>'.$Buttonlike.'</a>
                                <span class="Separator" '.$Style.'>|</span>
                                <a href="" class="LinkInfo Comment" id="Comment" '.$Style.'>Comment</a>
                                '.$Delete.'
                                <span class="ClearFix"></span>
                            </span>
                            <span class="moodContainer">
                                <span title="'.$Emoticon.'" class="iconMoods '.$Emoticon.'"></span>
                            </span>

                            <div class="ClearFix"></div>

                            <!--For Comment and Like Box-->
                            <div class="boxCommentLike" id="boxCommentLike">
								'.$DetailLikes.'
                            </div>
                        </div>
                    </li>
 				';
 				
 				$start++;
 				
 			}
 		}else{
 			$return = '<b>List Status not available.</b>';
 		}
 		
 		$nextStart = 0;
		if ($start < $jml) $nextStart = 1;
			
			return json_encode(array(
				'status' => 1,
				'html' => $return,
				'nextstart' => $nextStart,
				'start' => $start
			));
 		
 	}
	
	public function GetUserDetailPosts($UName, $Input, $limit = 0, $offset = 15) {
        $userStatusLike = new Userstatuslikes();
        $comment = new Userstatusdetail();
        
        $query = Database::Instance()->ExecuteQuery("
            SELECT * FROM userstatus WHERE UName = '".$UName."'
            LIMIT ".$limit.", ".$offset."
        ");

        $datas = Database::Instance()->Fetch($query);

        $posts = array();
        if (count($datas) > 0) {
            foreach ($datas as $data) {
                $dt = $data->USTime;
		 		if (is_string($dt)) {
					$dt=strtotime($dt);
				}
				$dt = $this->relativeTime($dt);

                $likes      = $userStatusLike->GetLikeStatus($data->USID, $Input);
		    	$comments   = $comment->GetComment($Input, $data->USID);

                if ($userStatusLike->YouLike)
		    		$statusLike = 'Unlike';
                else
                    $statusLike = 'Like';


                $userStatus             = new TempClass();
                $userStatus->USID       = $data->USID;
                $userStatus->USTime     = $dt;
                $userStatus->USStatus   = $this->convert_url($data->USStatus);
                $userStatus->statusLike = $statusLike;
                $userStatus->likes      = $likes;
                $userStatus->comments   = $comments;

                array_push($posts, $userStatus);
            }
        }

        return $posts;
    }
    
 
    	
}

?>