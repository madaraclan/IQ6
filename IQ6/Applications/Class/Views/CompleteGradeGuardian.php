<div class="GradeTable">
    <span class="Orange">Theory Grades</span>
    <table cellpadding="2" cellspacing="0" border="0" width="100%">
        <?php
            if(isset($score)){
                if(!empty($score))
                {
                    $oldTerm = '';
                    foreach($score as $scoreItem)
                    {
                    $change = false;
                        if($scoreItem->TEID != $oldTerm)
                        {
                            echo "<tr>
                                <td colspan=''3''>&nbsp;</td>
                            </tr><tr><td colspan='3'>".$scoreItem->TEName."</td></tr>";
                            $oldTerm = $scoreItem->TEID;
                            $change = true;
                        }
                        ?>
        <tr>
            <td width="60%"><?php echo $scoreItem->SName;?></td>
            <td width="15%" align="center"><?php echo $scoreItem->Score;?></td>
            <td width="5%" align="right"><?php
                foreach($gradeScore as $gradeItem)
                    {
                        if($scoreItem->Score > $gradeItem->SGLowerLimit)
                        {
                            echo $gradeItem->SGName;
                            break;
                        }
                    }
                ?></td>
        </tr>
                            <?php
                    }
                }
            }
        ?>
    </table>
</div>