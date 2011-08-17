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
            <br>
            <div>NIM : <?php echo $studentData->STCode; ?></div>
            <div class="Semester"><?php echo $currentTerm->TEName; ?></div>

            <ul class="TitleDescriptionList">
                <?php foreach($schedule as $scheduleItem) { ?>
                <li>
                    <a href="<?php $URI->WriteURI('App=Class&Com=MaterialGuardian&Act=DetailSubject&Param='.$studentData->STCode.'/'.$scheduleItem->SUID); ?>" class="Title"><?php echo $scheduleItem->SCCode;?> - <?php echo $scheduleItem->SName;?></a>
                    <span class="Description"><?php echo $scheduleItem->SDesc;?></span>
                </li>
                <?php } ?>
            </ul>
        </div>

        <div id="GradesBottom">

            <h2 class="HeaderIcon"><span class="Icon16 IconGrades16"></span>Grades</h2>

            <div class="LeftSide">
                <div class="HeaderDescription">
                    <span class="Left"><?php echo $beforeTerm->TEName; ?></span>
                    <a class="Right" href="<?php $URI->WriteURI('App=Class&Com=MaterialGuardian&Act=CompleteGrade&Param='.$studentData->STCode); ?>">see complete grades &raquo;</a>
                </div>

                <div class="ClearFix"></div>
                <div class="GradeTable">
                    <span class="Orange">Theory Grades</span>
                    <table cellpadding="2" cellspacing="0" border="0" width="100%">
                        <?php
                            if(isset($score)){
                                if(!empty($score))
                                {
                                    foreach($score as $scoreItem)
                                    {
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
            </div>

            <div class="RightSide">
                <div align="center">
                    <img src="<?php echo Path::View('Images/chart.jpg')?>" />
                </div>
            </div>

            <div class="ClearFix"></div>
            <br />
            <br />
        </div>
        
    </div>

    <div class="RightColumn">

        <div class="BoxWidget">
            <h2 class="HeaderIcon"><span class="Icon16 IconSchedule16"></span>Schedule</h2>
            <div class="HeaderDescription">
                <span class="Left"><?php echo date('l, d-m-Y',time());?></span>
                <a href="<?php $URI->WriteURI('App=Class&Com=MaterialGuardian&Act=CompleteSchedule&Param='.$studentData->STCode); ?>" class="Right">see complete schedule &raquo;</a>
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
                    <span class="Title"><a href="<?php $URI->WriteURI('App=Class&Com=MaterialGuardian&Act=DetailSubject&Param='.$studentData->STCode.'/'.$nextScheduleItem->SUID); ?>"><?php echo $nextScheduleItem->SName; ?></a></span>
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

        <div class="BoxWidget">
            <h2 class="HeaderIcon"><span class="Icon16 IconFinance16"></span>Finance</h2>
            <div class="HeaderDescription">
                <span class="Left">even semester</span>
                <a href="" class="Right">see financial reports &raquo;</a>
            </div>
            <div class="ClearFix"></div>
            <div class="Orange Top20">Payment Status</div>
            <ul class="ListQuick ListFinance">

                <li>
                    <span class="Status">BP3</span>
                    <span class="Left">Rp. 6.500.000,-</span>
                    <span class="Right">Due May 11th, 2011</span>
                    
                </li>

                <li>
                    <span class="Status">SKS</span>
                    <span class="Left">Rp. 1.920.000,-</span>
                    <span class="Right">Paid May 2nd, 2011</span>
                </li>
                
            </ul>
            <div class="ClearFix"></div>
        </div>
        
    </div>

    <div class="ClearFix"></div>
</div>