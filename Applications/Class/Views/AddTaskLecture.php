<script>
	$(document).ready(function(){
		$(".datepicker").datepicker();
		});
</script>
<div>

<form action="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=UploadTask'); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="TSCID" value="<?php echo $tscID;?>">
    Subject : <?php echo $firstMP->SName; ?><br>
    MP : <select name="mpid">
    <?php foreach($detailMP as $itemMP){
    ?>
    <option value="<?php echo $itemMP->MPID; ?>"><?php echo $itemMP->AttnNumber; ?> - <?php echo $itemMP->SubjectTitle; ?></option>
    <?php
    }?><br>
    </select><br>
    Task Name : <input type="text" name="tname"><br>
    Task Description : <textarea name="tdesc"></textarea><br>
    Task Deadline : <input type="text" name="deadline" class="datepicker"><br>
    File : <input type="file" name="fileTask"><br>
    File Answer : <input type="file" name="fileAnswer"><br>
    <input type="submit" value="Submit">
</form>

</div>