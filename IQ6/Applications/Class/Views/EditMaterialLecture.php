<div>

<form action="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=EditActionMaterial'); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="AMID" value="<?php echo $AMID;?>">
    Subject : <?php echo $firstMP->SName; ?><br>
    MP : <select name="mpid">
    <?php foreach($detailMP as $itemMP){
    ?>
    <option value="<?php echo $itemMP->MPID; ?>" <?php if($firstAM->MPID == $itemMP->MPID){ ?>selected="selected" <?php } ?>><?php echo $itemMP->AttnNumber; ?> - <?php echo $itemMP->SubjectTitle; ?></option>
    <?php
    }?><br>
    </select><br>
    <a href="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=DownloadAdditionalMaterial&Param='.$AMID); ?>">Current File</a>
    <br>
    <input type="file" name="fileMaterial"><br>
    <input type="submit" value="Submit">
</form>

</div>