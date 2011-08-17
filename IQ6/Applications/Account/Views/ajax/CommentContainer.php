<li id="<?php echo $StatusId; ?>" class="CommentContainer">
	             	<span class="profilePicture">
	             		<img src="<?php echo $Avatar; ?>" width="32" height="32" />
	                </span>
	
	                <span class="commentInfo">
	                	<form id="CommentUpload" name="CommentUpload" method="post">
	                    	<input type="hidden" id="StatusId" name="StatusId" value="<?php echo $StatusId; ?>" /> 	
	                		<textarea id="commentStatus" class="ShareStatus" name="commentStatus" style="height:10px;width:385px;">Write a comment...</textarea>
	                	</form>
	                </span>
	         </li>