<ul class="ListQuick">

<?php
    if(isset($schedule))
                {
                    if(!empty($schedule))
                    {
    foreach($schedule as $scheduleItem)
    {
        $tanggal = strtotime($scheduleItem->TSSDate);
        ?>
            <li>
                    <span class="Title"><a href="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=DetailSubject&Param='.$scheduleItem->SUID.'/'.$scheduleItem->SCHID); ?>"><?php echo $scheduleItem->SCHName;?> - <?php echo $scheduleItem->SName; ?></a></span>
                    <span class="Room"><?php echo $scheduleItem->RCCode; ?></span>
                    <span class="Time"><?php echo date('l, d-m-Y',$tanggal);?>,<?php
                        $time = strtotime($scheduleItem->SSStartTime);
                        echo date('H:i',$time); ?></span>
                    <div class="ClearFix"></div>
                    <span class="Status"><?php echo $scheduleItem->TSSType; ?></span>
                    <span class="Description">
                        <?php echo $scheduleItem->Objectives; ?>
                    </span>
                </li>
            <?php
    }
                    }
                }
        ?>

            </ul>