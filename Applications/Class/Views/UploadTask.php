<form action="<?php $URI->WriteURI('App=Class&Com=Material&Act=UploadTask'); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="TID" value="<?php echo $taskID;?>">
    <input type="file" name="fileAnswer">
    <input type="submit" value="Submit">
</form>
