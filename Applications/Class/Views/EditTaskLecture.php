<script>
	$(document).ready(function(){
		$(".datepicker").datepicker();
		});
</script>
<div>

<form action="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=UploadEditTask'); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="TID" value="<?php echo $currentTask->TID;?>">
    Subject : <?php echo $firstMP->SName; ?><br>
    MP : <select name="mpid">
    <?php foreach($detailMP as $itemMP){
    ?>
    <option value="<?php echo $itemMP->MPID; ?>" <?php if($currentTask->MPID == $itemMP->MPID){?> selected="selected" <?php } ?>><?php echo $itemMP->AttnNumber; ?> - <?php echo $itemMP->SubjectTitle; ?></option>
    <?php
    }?><br>
    </select><br>
    Task Name : <input type="text" name="tname" value="<?php echo $currentTask->TName;?>"><br>
    Task Description : <textarea name="tdesc"><?php echo $currentTask->TDesc;?></textarea><br>
    Task Deadline : <input type="text" name="deadline" class="datepicker" value="<?php $t = strtotime($currentTask->DeadLine);
        echo date('m/d/Y',$t); ?>" ><br>
    <a href="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=DownloadTask&Param='.$currentTask->TID); ?>">Current File</a>
    <br>
    File : <input type="file" name="fileTask"><br>
    <?php if($currentTask->TAID != '') { ?>
    <a href="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=DownloadTaskAnswer&Param='.$currentTask->TAID); ?>">Current Answer</a>
    <br>
    <?php } ?>
    File Answer : <input type="file" name="fileAnswer"><br>
    <input type="submit" value="Submit">
</form>

</div>