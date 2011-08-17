<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');

Import::Model('Account.User');
Import::Model('Account.Userstatus');
Import::Model('Account.Userfriend');

Import::Model('Account.Usermessage');

class _Profile extends Controller {
    private $userModel;
    
    public function __construct(URI $URI, Input $Input) {
        $this->userModel = new User();
        $this->userModel->ValidateLogin($Input)->ValidateLoginStatus('Activated', $Input);
    }

    public function MainLoad(URI $URI, Input $Input) {
        $UName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
        $this->ProfileUser($UName, $Input);
        //echo 'BB';
    }

    public function DetailLoad(URI $URI, Input $Input) {
        $UName = Encryption::Decrypt($URI->GetURI(3));
        $this->ProfileUser($UName, $Input);
    }
    
    public function GetMessageLoad(URI $URI, Input $Input){
    	
    	$UName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
    	
    	$MessageModel = new Usermessage();
    	$GetMessage = $MessageModel->GetMessageFront($UName, '', $UName);
    	
    	$return = $GetMessage;
    	
    	echo json_encode(array(
    		'status' => 1,
    		'html' => $return
    	));
    	
    }
    
    public function DetailMessageLoad(URI $URI, Input $Input){
    	
    	$UName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
    	$IdMessage = $Input->Post('idmessage');
    	
    	$MessageModel = new Usermessage();
    	$GetMessage = $MessageModel->GetMessageDetail($UName, $IdMessage, $UName);
    	
    	echo json_encode($GetMessage);
    	
    }
    
    public function MessagesLoad(URI $URI, Input $Input){
    	
    	$UName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
    	$user = $this->userModel->GetUserProfile($UName);
    	$followings = $this->userModel->GetUserFollowing($UName);
    	
    	$OptionName = '';
    	foreach($followings as $following){
    		$OptionName .= '<option value="'.$following->UName.'">'.$following->FirstName.' '.$following->LastName.'</option>';
    	}
    	
    	$MessageModel = new Usermessage();
    	$GetMessage = $MessageModel->GetMessageFront($UName, '', $UName);
    	
    	Import::Template('Home');
        Import::View('Messages', array(
        	'OptionName' => $OptionName,
        	'GetMessage' => $GetMessage,
        ));
    }
    
    public function SendMesageLoad(URI $URI, Input $Input){
    	
    	$UName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
    	
    	$To = $Input->Post('to');
    	$Content = $Input->Post('content');
    	$From = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
    	$Status = $Input->Post('Status');
    	
    	$ReTo = '';
    	$jmlTo = count($To);
    	$i = 0;
    	foreach($To as $User){
    		$ReTo .= $User;
    		++$i;
    		if ($i != $jmlTo) $ReTo .= ',';
    	}
    	
    	$MessageModel = new Usermessage();
    	$MessageModel->SendMessage($From, $ReTo, $Content, $Status);
    	
    	$GetMessage = $MessageModel->GetMessageFront($UName, 1, $UName);
    	
    	echo json_encode(array(
    		'status' => 1,
    		'Message' => $GetMessage
    	));
    	
    }
    
    function SendMessageDetailLoad(URI $URI, Input $Input){
    	$UName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
    	$IdMessageReply = $Input->Post('IdMessageReply');
    	$MessageReplyText = $Input->Post('MessageReplyText');
    	$IsRead = $Input->Post('IsRead');
    	
    	$MessageModel = new Usermessage();
    	$GetMessage = $MessageModel->SendMessageDetail($UName, $IdMessageReply, $MessageReplyText, $IsRead);
    	
    	echo json_encode(array(
    		'status' => 1,
    		'html' => $GetMessage,
    	));
    	
    }
    
    public function GetMessageDetailRealtimeLoad(URI $URI, Input $Input){
    	
    	$LastId = $Input->Post('LastId');
    	$IdMessage = $Input->Post('IdMessage');
    	
    	$MessageModel = new Usermessage();
    	$GetMessage = $MessageModel->GetMessageRealtime($LastId, $IdMessage);
    	
    	echo json_encode(array(
    		'status' => 1,
    		'html' => $GetMessage
    	));
    	
    }

    private function ProfileUser($UName, $Input) {
    	//echo 'DD';
    	
    	
		
    	
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
       
        Database::Instance()->SetConfig("localhost", "mastertables");
        Database::Instance()->Connect();
        
        $dataFriend = json_decode($friend->PictureFriendTag($Input));
        
        
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
        
    		
    		$JmlMessage = new Usermessage();
    		$NoReadMessage = $JmlMessage->JmlReadMessage($UName);
        
        Import::Template($user->FirstName.' '.$user->LastName);
        Import::View('Profile', array(
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
        'JmlNotif' => $jmlnotif,
        'JmlMessage' => $NoReadMessage
        ));
    }
    
    function JmlMessageRealtimeLoad(URI $URI, Input $Input){
    	$UName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
    	$JmlMessage = new Usermessage();
    	$NoReadMessage = $JmlMessage->JmlReadMessage($UName);
    	echo json_encode(array(
    		'status' => 1,
    		'html' => $NoReadMessage
    	));
    }
}
