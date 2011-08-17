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

class _AjaxComment extends Controller{
	
	public $TokenId;
	
	/*
	 * COMMENT
	 */
	
function DeleteCommentLoad(URI $URI, Input $Input){

		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
		
        $_UserStatusDetail = new Userstatusdetail();
        $_UserStatusDetail->DeleteComment_WithOutParent($Input);
        
        //$IdComment = $Input->Post('IdStatus');
        
        //Database::Instance()->ExecuteQuery("
        //delete from userstatusdetail where USDID = '.$IdComment.'
        //");
        
		echo json_encode(array('status' => 1));
		
	}
	
	function CommentContainerLoad(URI $URI, Input $Input){
		
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        
        // Sign in
    	$UserSignIn = new User();
    	
    	Database::Instance()->SetConfig("localhost", "mastertables");
        Database::Instance()->Connect();
    	
    	$DataUser = ($UserSignIn->GetBasicInformation($Input));
    	
    	$AvatarFilePath = ($DataUser->AvatarFilePath)
                          ? 'p_small_'.$DataUser->AvatarFilePath.'.jpg' : 'thumb1.jpg';
    	//if (!$AvatarFilePath) $AvatarFilePath = '';
		
                          /*
		echo '<li id="'.$Input->Post('StatusId').'" class="CommentContainer">
	             	<span class="profilePicture">
	             		<img src="'.Config::Instance(SETTING_USE)->photos.$AvatarFilePath.'" width="32" height="32" />
	                </span>
	
	                <span class="commentInfo">
	                	<form id="CommentUpload" name="CommentUpload" method="post">
	                    	<input type="hidden" id="StatusId" name="StatusId" value="'.$Input->Post('StatusId').'" /> 	
	                		<textarea id="commentStatus" class="ShareStatus" name="commentStatus" style="height:10px;width:385px;">Write a comment...</textarea>
	                	</form>
	                </span>
	         </li>';
	         */
		
		Import::View('ajax/CommentContainer', array(
			'StatusId' => $Input->Post('StatusId'),
			'Avatar' => Config::Instance(SETTING_USE)->photos.$AvatarFilePath
		));
	
	}
	
	
	
	function LikesStatusCommentLoad(URI $URI, Input $Input){
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
        $Userstatuslikes = new Userstatusdetaillike();
        $DataUserLike = $Userstatuslikes->LikeStatus($Input);
        echo $DataUserLike;
	}
	
	
	
	function UpdateCommentLoad(URI $URI, Input $Input){
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
	
        $ShareStatus = new Userstatusdetail();
        $ResponseStatus = $ShareStatus->ShareStatus($Input);
        
        //echo $Input->Post('Status', false);
        
        echo $ResponseStatus;
	}
	
	function RealtimeCommentLoad(URI $URI, Input $Input){
		Database::Instance()->SetConfig("localhost", "socialnetwork");
        Database::Instance()->Connect();
	
        $ShareStatus = new Userstatusdetail();
        $ResponseStatus = $ShareStatus->RealtimeAmbilComment($Input, $Input->Post('LastCommentId'));
		
        echo $ResponseStatus;
	}
	
	
	/*
	 * END COMMENT
	 */
	
	
	
}