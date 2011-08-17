<script type="text/javascript">
    $(function() {
        $("#tabMaterial").Tab();
    });
    $(document).ready(function(){
        $("#itemMaterial").change(function(){
            var tmp = $("#itemMaterial").val();
            document.location = "<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=DetailSubject'); ?>"+tmp;
        });
        $(".btnDelete").live('click',function(e){
            e.preventDefault();
            if(confirm('Are you sure to Delete?'))
            {
                $.post('<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=DeleteMaterial'); ?>',{'AMID':$(this).attr('data')},function(data){
				eval(data);
				if(res.type == 'success')
				{
                    alert('Success Delete Additional Material');
					setTimeout('location.reload(true)',1000);
				}
				});	
            };
        });
        $(".btnEdit").live('click',function(e){
            if(confirm('Are you sure to Edit?'))
            {
                document.location = "<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=EditMaterial'); ?>"+$(this).attr('data');
            };
        });
        $(".btnDeleteTask").live('click',function(e){
            e.preventDefault();
            if(confirm('Are you sure to Delete?'))
            {
                $.post('<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=DeleteTask'); ?>',{'TID':$(this).attr('data')},function(data){
				    eval(data);
                    if(res.type == 'success')
                    {
                        alert('Success Delete Task');
                        setTimeout('location.reload(true)',1000);
                    }
				});
            };
        });
        $(".btnEditTask").live('click',function(e){
            if(confirm('Are you sure to Edit?'))
            {
                document.location = "<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=EditTask'); ?>"+$(this).attr('data');
            };
        });
    });
</script>
<!--Content Two Column-->
<div class="ContentTwoLayout">
    <div class="LeftColumn" >

        <div id="Materials">
            <h2 class="HeaderIcon"><span class="Icon16 IconMaterials16"></span>Materials</h2>
            <span class="SmallDescription">&nbsp;</span>
            <div class="SimpleBreadCrumb">
                <span>Class</span>
                <span class="Separator">&raquo;</span>
                <a href="<?php URI::WriteURI('App=Class&Com=MaterialLecture')?>">Materials</a>
                <span class="Separator">&raquo;</span>
                <span>Course Outline</span>
            </div>

            <div id="jump">
                <span class="label">Jump to :</span>
                <select name="material" id="itemMaterial">
                    <?php
                        foreach($schedule as $scheduleItem)
                        {
                    ?>
                    <option value="<?php echo $scheduleItem->SUID.'/'.$scheduleItem->SCHID; ?>" <?php if ($currentMP == $scheduleItem->SUID.'/'.$scheduleItem->SCHID){ ?>selected="selected"<?php } ?> ><?php echo $scheduleItem->SCHName;?> - <?php echo $scheduleItem->SName;?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>

            <div id="tabMaterial" class="tabContent">
                <ul class="tabItem">
                    <li><a href="#!tabInformation">Information</a></li>
                    <li><a href="#!tabTopics">Topics</a></li>
                    <li><a href="#!tabAssignments">Assignments</a></li>
                    <li class="last"><?php echo $currentTerm->TEName; ?></li>
                </ul>

                <div class="tabContainer">
                <?php $sapItem = $detailMP[0]; ?>
                    <!--tab information-->
                    <div id="tabInformation" class="tab">

                        <div class="courseInfo">
                            <div class="Left">
                                <span class="label">Course Code</span>
                                <span class="sp">:</span>
                                <span class="value"><?php echo $sapItem->SCCode; ?></span>
                            </div>
                            <div class="Right">
                                <span class="label">Revision Date</span>
                                <span class="sp">:</span>
                                <span class="value"><?php $revdate = strtotime($sapItem->RevDate); echo date('d/m/Y',$revdate); ?></span>
                            </div>
                            <div class="ClearFix"></div>
                            <div class="Left" style="margin-top: 3px">
                                <span class="label">Course Name</span>
                                <span class="sp">:</span>
                                <span class="value"><?php echo $sapItem->SName; ?></span>
                            </div>

                            <div class="ClearFix"></div>
                        </div>

                        <div class="HrGrayWhite"></div>

                        <div class="courseDesc">

                            <div class="row">
                                <span class="header">
                                    <h2>Description</h2>
                                </span>
                                <div class="contentDesc">
                                    <?php echo $sapItem->SDesc; ?>
                                </div>
                            </div>

                            <div class="row">
                                <span class="header">
                                    <h2>Graduate Competency</h2>
                                </span>
                                <div class="contentDesc">
                                    <?php echo $sapItem->SGradComp; ?>
                                    <br /><br />
                                    <div class="row">
                                        <span class="header">
                                            <h2>Employability and Entrepreneurial Skills</h2>
                                        </span>
                                        <div class="contentDesc">
                                            <?php echo $sapItem->EESkill; ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <span class="header">
                                            <h2>Study Program Specific Outcomes</h2>
                                        </span>
                                        <div class="contentDesc">
                                            <?php echo $sapItem->SPSO; ?>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="row">
                                <span class="header">
                                    <h2>Learning Outcomes</h2>
                                </span>
                                <div class="contentDesc">
                                    <?php /*echo nl2br("Aliquam erat volutpat :
                                    LO1 : In malesuada arcu vel purus pellentesque volutpat.
                                    LO2 : Aenean mattis tempus neque, sit amet posuere neque blandit id.
                                    LO3 : Quisque imperdiet arcu eget nulla commodo semper.
                                    LO4 : Ut commodo elit ante, at gravida erat.
                                    LO5 : Duis lectus lectus, venenatis non congue quis, aliquet ut felis.
                                    LO6 : Donec placerat vehicula odio quis porta.
                                    LO7 : Phasellus mauris risus, lobortis pretium rhoncus ut, eleifend at nunc.
                                    LO8 : Nullam congue, elit ac cursus pretium, neque eros auctor libero, facilisis ultricies lectus felis non lacus.
                                    LO9 : Pellentesque justo tortor, blandit ac sodales id, semper vitae tortor.
                                    LO10 : Duis feugiat metus blandit arcu venenatis ac malesuada ligula volutpat.
                                    LO11 : Etiam vitae iaculis sem.
                                    LO12 : Proin iaculis est at quam malesuada ac hendrerit velit viverra.
                                    LO13 : Vivamus quis nulla massa.");*/?>
                                    <?php foreach($resultLO as $itemLO){
                                        echo $itemLO->LOCode.' : '.$itemLO->LODesc.'<br>';
                                    } ?>
                                </div>
                            </div>

                            <div class="row">
                                <span class="header">
                                    <h2>Teaching and Learning Strategies</h2>
                                </span>
                                <div class="contentDesc">
                                    <?php echo $sapItem->TLS; ?>
                                </div>
                            </div>

                            <div class="row">
                                <span class="header">
                                    <h2>Textbooks</h2>
                                </span>
                                <div class="contentDesc">
                                    <?php /*echo nl2br("1. Aenean et eros quis orci gravida ullamcorper.
                                    2. Phasellus non turpis quis urna consequat sodales.
                                    3. Nam hendrerit ornare pellentesque.
                                    4. Fusce non dolor arcu.
                                    5. Maecenas pharetra dolor et ante venenatis at faucibus est sollicitudin.
                                    6. Donec imperdiet tristique nulla, ut dignissim nisi scelerisque sed.
                                    7. Maecenas vel dui a nulla pellentesque tincidunt.
                                    8. Mauris non ligula nec nisi ullamcorper varius. Ut quis euismod nibh.
                                    9. Mauris pellentesque pellentesque erat, ac auctor leo dapibus nec.
                                    10. Mauris tincidunt porta arcu ut rhoncus.

                                    Donec hendrerit nunc a leo accumsan vehicula.");*/?>
                                    <?php
                                    $iter = 1;
                                    foreach($resultBook as $itemBook)
                                    {
                                        echo $iter++.'. '.$itemBook->RBTitle.'<br>';
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="row">
                                <span class="header">
                                    <h2>Evaluations</h2>
                                </span>
                                <div class="contentDesc">
                                    <div style="height: 2px"></div>
                                    <div class="row">
                                        <span class="header">
                                            <h2>Theory</h2>
                                        </span>
                                        <div class="contentDesc">
                                            <?php echo $sapItem->ET; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <span class="header">
                                            <h2>Practicum</h2>
                                        </span>
                                        <div class="contentDesc">
                                            <?php echo $sapItem->EP; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <span class="header">
                                            <h2>Final Evaluation Score</h2>
                                        </span>
                                        <div class="contentDesc">
                                            <?php echo $sapItem->FES; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!--tab topics-->
                    <div id="tabTopics" class="tab">
                        <div class="contentTopic">
                            <h3>Theory</h3>

                            <table class="tabulatedData" width="100%" cellpadding="4" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="10%">Session</th>
                                        <th width="10%">Mode</th>
                                        <th width="52%">Topics</th>
                                        <th width="15%">Date</th>
                                        <th>Download</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach($detailMP as $itemMP)
                                    {
                                    $class = ($i++%2 == 1) ? 'class="odd"' : '';
                                    ?>
                                    <tr <?php echo $class?>>
                                        <td align="center"><?php echo $itemMP->AttnNumber;?></td>
                                        <td align="center"><?php echo $itemMP->TSSType; ?></td>
                                        <td><a href="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=MPDetail&Param='.$itemMP->MPID); ?>"><?php echo $itemMP->SubjectTitle;?></a></td>
                                        <td align="center"><?php $tssdate = strtotime($itemMP->TSSDate); echo date('d-m-Y',$tssdate);  ?></td>
                                        <td align="center"><a class="Icon16 iconDownload16" href="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=DownloadMaterial&Param='.$itemMP->MPID); ?>"></a></td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="contentTopic">
                            <h3>Additional Material <a href="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=AddMaterial&Param='.$itemMP->TSCID); ?>">[Add New Material]</a></h3>

                            <table class="tabulatedData" width="100%" cellpadding="4" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="10%">Session</th>
                                        <th width="10%">Mode</th>
                                        <th width="52%">Topics</th>
                                        <th width="15%">Date</th>
                                        <th width="15%">Edit</th>
                                        <th width="15%">Delete</th>
                                        <th>Download</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach($addtionalMaterial as $itemAM)
                                    {
                                    $class = ($i++%2 == 1) ? 'class="odd"' : '';
                                    ?>
                                    <tr <?php echo $class?>>
                                        <td align="center"><?php echo $itemMP->AttnNumber;?></td>
                                        <td align="center"><?php echo $itemAM->TSSType; ?></td>
                                        <td><a href="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=MPDetail&Param='.$itemAM->MPID); ?>"><?php echo $itemAM->SubjectTitle;?></a></td>
                                        <td align="center"><?php $tssdate = strtotime($itemAM->TSSDate); echo date('d-m-Y',$tssdate);  ?></td>
                                        <td><a data="<?php echo $itemAM->AMID; ?>" class="btnEdit">Edit</a></td>
                                        <td><a data="<?php echo $itemAM->AMID; ?>" class="btnDelete">Delete</a></td>
                                        <td align="center"><a class="Icon16 iconDownload16" href="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=DownloadAdditionalMaterial&Param='.$itemAM->AMID); ?>"></a></td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>

                    <!--tab assignments-->
                    <div id="tabAssignments" class="tab">
                        <div class="contentTopic">
                            <h3>Main Assignment</h3>

                            <table class="tabulatedData" width="100%" cellpadding="4" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="10%">Session</th>
                                        <th width="43%">Topics</th>
                                        <th width="12%">Deadline</th>
                                        <th width="12%">Get Answer</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach($detailTask as $taskItem)
                                    {
                                        if($taskItem->TStatus == 'Main')
                                        {
                                            $class = ($i++%2 == 1) ? 'class="odd"' : '';
                                            ?>
                                            <tr <?php echo $class?>>
                                                <td><?php echo $taskItem->AttnNumber;?></td>
                                                <td><?php echo $taskItem->TName;?></td>
                                                <td align="center"><?php $dt=strtotime($taskItem->DeadLine); echo date('d-m-Y',$dt); ?></td>
                                                <td align="center"><a href="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=GetAnswer&Param='.$taskItem->TID); ?>">Get Answer</a></td>
                                                <td align="center">
                                                    <div class="Left" style="margin-left: 10px">
                                                        <a class="Icon16 iconDownload16 Left" href="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=DownloadTask&Param='.$taskItem->TID); ?>"></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    if($i == 1)
                                    {
                                        ?>
                                        <tr class="odd">
                                            <td colspan="6" align="center">No Assignment Yet.</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <div style="height: 20px"></div>
                            <h3>Additional Assignment <a href="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=AddTask&Param='.$itemMP->TSCID); ?>">[Add New Task]</a></h3>
                            <table class="tabulatedData" width="100%" cellpadding="4" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="10%">Session</th>
                                        <th width="43%">Topics</th>
                                        <th width="12%">Deadline</th>
                                        <th width="12%">Get Answer</th>
                                        <th>Action</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <?php
                                    $i = 1;
                                    foreach($detailTask as $taskItem)
                                    {
                                        if($taskItem->TStatus == 'Additional')
                                        {
                                            $class = ($i++%2 == 1) ? 'class="odd"' : '';
                                            ?>
                                            <tr <?php echo $class?>>
                                                <td><?php echo $taskItem->AttnNumber;?></td>
                                                <td><?php echo $taskItem->TName;?></td>
                                                <td align="center"><?php $dt=strtotime($taskItem->DeadLine); echo date('d-m-Y',$dt); ?></td>
                                                <td align="center"><a href="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=GetAnswer&Param='.$taskItem->TID); ?>">Get Answer</a></td>
                                                <td align="center">
                                                    <div class="Left" style="margin-left: 10px">
                                                        <a class="Icon16 iconDownload16 Left" href="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=DownloadTask&Param='.$taskItem->TID); ?>"></a>
                                                    </div>
                                                </td>
                                                <td><a data="<?php echo $taskItem->TID; ?>" class="btnEditTask">Edit</a></td>
                                                <td><a data="<?php echo $taskItem->TID; ?>" class="btnDeleteTask">Delete</a></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    if($i == 1)
                                    {
                                        ?>
                                        <tr class="odd">
                                            <td colspan="7" align="center">No Assignment Yet.</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        

    </div>

    <div class="RightColumn">

        <div class="BoxWidget">
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
                    <span class="Title"><a href="<?php $URI->WriteURI('App=Class&Com=MaterialLecture&Act=DetailSubject&Param='.$nextScheduleItem->SUID.'/'.$nextScheduleItem->SCHID); ?>"><?php echo $nextScheduleItem->SCHName; ?> - <?php echo $nextScheduleItem->SName; ?></a></span>
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
    <div style="height: 15px"></div>
    <div class="Left"></div>
</div>
 
