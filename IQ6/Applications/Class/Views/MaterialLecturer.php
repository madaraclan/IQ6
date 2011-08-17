<!--Content Two Column-->
<div class="ContentTwoLayout">
    <div class="LeftColumn" >
        <div id="Materials">
            <h2 class="HeaderIcon"><span class="Icon16 IconMaterials16"></span>Materials</h2>
            <span class="SmallDescription">Check your materials bellow.</span>
            <div class="SimpleBreadCrumb">
                <span>Class</span>
                <span class="Separator">&raquo;</span>
                <span>Materials</span>
            </div>

            <div class="Semester"><?php echo $currentTerm->TEName; ?></div>

            <ul class="TitleDescriptionList">
                <?php foreach($subjectList as $scheduleItem) { ?>
                <li>
                    <a href="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=DetailSubject&Param='.$scheduleItem->SUID.'/'.$scheduleItem->SCHID); ?>" class="Title"><?php echo $scheduleItem->SCHName;?> - <?php echo $scheduleItem->SCCode;?> - <?php echo $scheduleItem->SName;?></a>
                    <span class="Description"><?php echo $scheduleItem->SDesc;?></span>
                </li>
                <?php } ?>
            </ul>
        </div>

    </div>

    <div class="RightColumn">

        <div class="BoxWidget">
            <h2 class="HeaderIcon"><span class="Icon16 IconSchedule16"></span>Schedule</h2>
            <div class="HeaderDescription">
                <span class="Left"><?php echo date('l, d-m-Y',time());?></span>
                <a href="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=CompleteSchedule'); ?>" class="Right">see complete schedule &raquo;</a>
            </div>
            <div class="ClearFix"></div>
            
            <ul class="ListQuick">

<?php
    if(isset($nextSchedule))
                {
                    if(!empty($nextSchedule))
                    {
                        $count = 3;
    foreach($nextSchedule as $nextScheduleItem)
    {
        ?>
            <li>
                    <span class="Title"><a href="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=DetailSubject&Param='.$nextScheduleItem->SUID.'/'.$nextScheduleItem->SCHID); ?>"><?php echo $scheduleItem->SCHName;?> - <?php echo $nextScheduleItem->SName; ?></a></span>
                    <span class="Room"><?php echo $nextScheduleItem->RCCode; ?></span>
                    <span class="Time"><?php
                        $time = strtotime($nextScheduleItem->SSStartTime);
                        echo date('H:i',$time); ?></span>
                    <div class="ClearFix"></div>
                    <span class="Status"><?php echo $nextScheduleItem->TSSType; ?></span>
                    <span class="Description">
                        <?php echo $nextScheduleItem->Objectives; ?>
                    </span>
                </li>
            <?php
        $count--;
        if($count == 0)
            break;
    }
                    }
                }
        ?>

            </ul>
        </div>

    </div>

    <div class="ClearFix"></div>
</div>