<script>
    $(document).ready(function(){
        $("#formSubmit").submit(function(e){
            var ok = true;
            var item = $('.answer');
            for(var i=0;i < item.length ;i++)
            {
                if(isNaN($(item[i]).val()) || $(item[i]).val() == '' || $(item[i]).val() > 100 || $(item[i]).val() < 0)
                    ok = false;
            }
            if(!ok)
            {
                e.preventDefault();
                alert('Your data is invalid');
            }
        });
    });
</script>

<form action="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=PostStudentAnswer'); ?>" method="post" id="formSubmit">
<table>
    <tr>
        <th>NIM</th>
        <th>Name</th>
        <th>Answer</th>
        <th>Score</th>
    </tr>
    <?php
    $idTHTS = array();
    foreach($studentAnswer as $answerItem) {
        array_push($idTHTS,$answerItem->THTSID);
        ?>
    <tr>
        <td><?php echo $answerItem->STCode; ?></td>
        <td><?php echo $answerItem->STFirstName.' '.$answerItem->STLastName; ?></td>
        <td><?php if($answerItem->THTSFilePath != ''){ ?><a href="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=DownloadStudentAnswer&Param='.$answerItem->THTSID); ?>">Get Answer</a><?php } ?></td>
        <td><?php if($answerItem->THTSFilePath != ''){?><input type="text" class="answer" name="answer_<?php echo $answerItem->THTSID; ?>" value="<?php echo $answerItem->Score; ?>"><?php } ?></td>
    </tr>
    <?php
    } ?>
</table>
<input type="hidden" name="idTHTS" value="<?php echo implode(',',$idTHTS);?>">
<input type="submit" value="Submit">
</form>
