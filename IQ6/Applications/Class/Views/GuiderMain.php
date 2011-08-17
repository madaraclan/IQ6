<form action="<?php $URI->WriteURI('App=Class&Com=MaterialGuardian&Act=ViewStudent'); ?>" method="post">
<select name="stCode">
 <?php
foreach($studentData as $studentItem)
{
    ?>
        <option value="<?php echo $studentItem->STCode; ?>"><?php echo $studentItem->STCode; ?></option>
        <?php
}
?>
</select>
    <input type="submit" value="View" />
</form>