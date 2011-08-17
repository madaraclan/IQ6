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
Import::Library('Plugin.NovComet');

class _AjaxStatus extends Controller{
	
	public $TokenId;
	
	/*
	 * STATUS
	 */
	
	function CometLoad(URI $URI, Input $Input){
		
		
	$comet = new NovComet();
	/*
	$publish = filter_input(INPUT_GET, 'publish', FILTER_SANITIZE_STRING);
	if ($publish != ''){
		echo $comet->publish($publish);
	}else{
		foreach(filter_var_array($_GET['subscribed'], FILTER_SANITIZE_NUMBER_INT) as $key => $value){
			$comet->setVar($key, $value);
		}
		echo $comet->run();
	}
	*/
	
	$publish = $Input->post('publish');
	
	if ($publish){
		echo $comet->publish($publish);
	}else{
	
		$s = $Input->post('subscribed');

		$s1 = explode(';', $s);
		$s1 = array_map('trim', $s1);
		
		foreach($s1 as $item){
			$s2 = explode('=', $item);
			$s2 = array_map('trim', $s2);
			if ($s2[0] && $s2[1])
			$comet->setVar($s2[0], $s2[1]);
			//echo $s2[0].'='.$s2[1].'<br />';
		}
		
	//$comet->setVar(, );
	echo $comet->run();
	
	}
	
	}
	
	function DeleteStatusLoad(URI $URI, Input $Input){

		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
		
        $_UserStatus = new Userstatus();
        $_UserStatus->DeleteUserStatus($Input);
        
        /**
         * Database::Instance()->ExecuteQuery('
        	
        ');
         */
        
        //$IdStatus = $Input->Post('IdStatus');
        
        //Database::Instance()->ExecuteQuery("
        //delete from userstatus where USID = '.$IdStatus.'
        //");
                
        //Database::Instance()->ExecuteQuery("
        //delete from userstatusdetail where USID = '.$IdStatus.'
        //");
        
        
		echo json_encode(array('status' => 1));
		
	}
function ParsingURLLoad(URI $URI, Input $Input){
		//echo $Input->Post('url').$Input->Post('status');
		$_url = $Input->Post('url');
		
		//$ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $_url);
		//$ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $_url);
		
		if (preg_match("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", $_url) ||
		preg_match("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", $_url)){
		
		if (preg_match("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", $_url)) {
			$_url = 'http://'.$_url;
		}
			
		$html = file_get_html($_url);
		$title = '';
		$detail = '';
		$img = '';
		$url = $Input->Post('Html');
		foreach($html->find('title') as $e){
			$title = $e->plaintext;
		}
		foreach($html->find('meta[name=description]') as $e){
			$detail = $e->content;
		}
		if (!$detail){
		foreach($html->find('meta[name=Description]') as $e){
			$detail = $e->content;
		}
		}
		
		foreach($html->find('meta') as $e){
			$tempimg = $e->content;
			$jpeg = '.jpg';
			$pos = strpos($tempimg, $jpeg);
			if ($pos){
				$img = '<img src="'.$tempimg.'" />';
				break;
			}
			
			if (!$img){
				$png = '.png';
				$pos = strpos($tempimg, $png);
				if ($pos){
					$img = '<img src="'.$tempimg.'" />';
					break;
				}
			}
			
		}
		
		if (!$img){
		foreach($html->find('img') as $e){
			$tempimg = $e->outertext;
			$jpeg = '.jpg';
			$pos = strpos($tempimg, $jpeg);
			if ($pos){
				$img = $tempimg;
				break;
			}
		}
		}
		
		$service = '';$formopen = '';$formclose = '</a>';
		if (preg_match('/^http\:\/\/www\.youtube\.com/',$_url) || 
			preg_match('/^http\:\/\/youtu.be\//',$_url) || 
			preg_match('/^http\:\/\/youtube\.com/',$_url)){
			$service = "youtube";
			$formopen = '<a href="'.$_url.'" class="embedmedia" id="embedmedia" rel="'.$service.'">';
		}else if (preg_match('/^http\:\/\/vimeo\.com/',$_url)){
			$service = "vimeo";
			$formopen = '<a href="'.$_url.'" class="embedmedia" id="embedmedia" rel="'.$service.'">';
		}else{
			$service = "link";
			$formopen = '<a href="'.$_url.'" target="blank" class="link" id="link" rel="'.$service.'">';
		}
		
		$p = parse_url($_url, PHP_URL_HOST);
		
		echo json_encode(array(
			'status' => 1,
			'title' => '<a href="'.$_url.'" target="_blank"><b>'.$title.'</b></a><div><a href="http://'.$p.'" target="_blank">'.$p.'</a></div>',
			'detail' => '<p>'.$detail.'</p>',
			'img' => $formopen.$img.$formclose,
			'url' => '<a href="'.$url.'">'.$url.'</a>'
		));
		
		}else{
			
			echo json_encode(array('status' => 0));
			
		}
		
	}
function RealTimeGetStatusLoad(URI $URI, Input $Input){
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
	
        $ShareStatus = new Userstatus();
        $ResponseStatus = $ShareStatus->RealTimeGetStatus($Input, $Input->Post('LastId'));
		
        echo $ResponseStatus;
	}
	
	function RealTimeGetTimeLoad(URI $URI, Input $Input){
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
	
        $ShareStatus = new Userstatus();
        $ResponseStatus = $ShareStatus->RealTimeGetTime($Input);
		
        echo $ResponseStatus;
	}
function LikesStatusLoad(URI $URI, Input $Input){
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        $Userstatuslikes = new Userstatuslikes();
        $DataUserLike = $Userstatuslikes->LikeStatus($Input);
        echo $DataUserLike;
	}
function UpdateStatusLoad(URI $URI, Input $Input){
		
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
	
        $ShareStatus = new Userstatus();
        $ResponseStatus = $ShareStatus->ShareStatus($Input);
		
        echo $ResponseStatus;
        
	}
function GetStatusLoad(URI $URI, Input $Input){
		
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
	
        $ShareStatus = new Userstatus();
        $ResponseStatus = $ShareStatus->GetStatus($Input, $Input->Post('start'));
		
        echo $ResponseStatus;
        
	}
	
	function NotifStatusLoad(URI $URI, Input $Input){
		$userStatus = new Userstatus();
   		$NotifDetail = $userStatus->Notif($Input);
   		echo json_encode(array(
   			'status' => 1,
   			'html' => $NotifDetail
   		));
	}
	
	function RealtimeNotifLoad(URI $URI, Input $Input){
		$userStatus = new Userstatus();
   		$NotifDetail = $userStatus->RealtimeJmlNotif($Input);
   		echo json_encode(array(
   			'status' => 1,
   			'html' => $NotifDetail
   		));
	}
	
	
function GetStatusProfileLoad(URI $URI, Input $Input){
		
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
	
        $ShareStatus = new Userstatus();
        $ResponseStatus = $ShareStatus->GetStatusProfile($Input, $Input->Post('start'));
		
        echo $ResponseStatus;
        
	}
	
	/*
	 * END STATUS
	 */
	
	
}
