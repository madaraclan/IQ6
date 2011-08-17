<div>
<?php
    $sapItem = $detailMP[0];
?>
Name :
<?php
    echo $sapItem->SAPCode;
?>
<br>
    Code:
<?php
    echo $sapItem->SAPName;
?>
<br>
    Description:
<?php
    echo $sapItem->SAPDesc;
?>
<br>
    Objective:
<?php
    echo $sapItem->SAPObjectives;
?>
<br>
    Mind Map:
<?php
    echo $sapItem->SAPMindMap;
?>
<br>
    Detail:
<?php
    foreach($detailMP as $itemMP)
    {
        ?>
            <br>
    Title MP:<a href="<?php $URI->WriteURI('App=Class&Com=Material&Act=MPDetail&Param='.$itemMP->MPID); ?>">
<?php
        echo $itemMP->SubjectTitle;
?></a>
<br>
    Objective:
<?php
        echo $itemMP->Objectives;
?>
<br>
    Type:
<?php
        echo $itemMP->TSSType;
?>
<br>
            <?php
    }
?>
    </div>