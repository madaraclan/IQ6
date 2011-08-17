<div>

<form action="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=UploadMaterial'); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="TSCID" value="<?php echo $tscID;?>">
    Subject : <?php echo $firstMP->SName; ?><br>
    MP : <select name="mpid">
    <?php foreach($detailMP as $itemMP){
    ?>
    <option value="<?php echo $itemMP->MPID; ?>"><?php echo $itemMP->AttnNumber; ?> - <?php echo $itemMP->SubjectTitle; ?></option>
    <?php
    }?><br>
    </select><br>
    <input type="file" name="fileMaterial"><br>
    <input type="submit" value="Submit">
</form>

</div>