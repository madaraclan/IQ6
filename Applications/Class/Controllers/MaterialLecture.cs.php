<?php
/**
 * Created by JetBrains PhpStorm.
 * User: William
 * Date: 7/24/11
 * Time: 7:58 PM
 * To change this template use File | Settings | File Templates.
 */
 
class _MaterialLecture extends Controller {

    public function __construct()
    {
        Import::Model("class.AdditionalMateri");
        Import::Model("class.Lecturer");
        Import::Model("class.Term");
        Import::Model("class.SchoolGrade");
        Import::Model("class.Task");
        Import::Model("class.LO");
        Import::Model("class.ReferenceBook");
        Import::Entity("class.AdditionalMateri");
        Import::Model("class.TrHeaderTaskForStudent");
        Import::Entity("class.TrHeaderTaskForStudent");
        Import::Model("class.TaskAnswer");
        Import::Entity("class.TaskAnswer");
        Import::Entity("class.Task");
        Import::Model("class.TrDetailTaskForStudent");
        Import::Library("Parser.File");
    }
    public function MainLoad(URI $URI, Input $Input) {
        $user = NULL;
        if($Input->Cookie()->GetValue('user')!=NULL)
            $user = $Input->Cookie()->GetValue('user');
        
		else if($Input->Session('EDU')->GetValue('user')!=NULL)
            $user = $Input->Session()->GetValue('user');
        else
           redirect($URI->ReturnURI('App=Home&Com=Session'));
		   
        if($user != NULL)
        {
            if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $term = new Term();
                $termResult = $term->Equal('IsActive','Y')->First();
                $termBefore = $term->Equal('IsActive','N')->OrderBy('EndPeriode','DESC') ->First();
                $data = array();
                $lecturer = new Lecturer();
                $lectureResult = $lecturer->Join('Employee','Employee.EID','Lecturer.EID')->Equal('UName',$user->UName)
                        ->Join('TrLecturerToClass','TrLecturerToClass.LTID','Lecturer.LID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrLecturerToClass.TSCID')
                        ->Join('SchoolClass','SchoolClass.SCHID','TrHeaderStudentClass.SCHID')
                        ->Join('Subject','Subject.SUID','TrHeaderStudentClass.SUID')
                        ->Get();
                $lectureSchedule = $lecturer->Join('Employee','Employee.EID','Lecturer.EID')->Equal('UName',$user->UName)
                        ->Join('TrLecturerToClass','TrLecturerToClass.LTID','Lecturer.LID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrLecturerToClass.TSCID')
                        ->Join('TrStudentSchedule','TrLecturerToClass.TSCID','TrStudentSchedule.TSCID')
                        ->Join('SchoolClass','SchoolClass.SCHID','TrHeaderStudentClass.SCHID')
                        ->Join('Subject','Subject.SUID','TrHeaderStudentClass.SUID')
                        ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                        ->Join('SchoolRoomClass','SchoolRoomClass.RCID','TrStudentSchedule.RCID')
                        ->Join('StudyShift','StudyShift.SSID','TrStudentSchedule.SSID')
                        ->Equal('TEID',$termResult->TEID)
                        ->Equal('TSSDate',date('Y-m-d',time()))
                        ->OrderBy('TSSDate','DESC')
                        ->Get();
                $data['currentTerm'] = $termResult;
                $data['schedule'] = $lectureSchedule;
                $data['subjectList'] = $lectureResult;
                Import::Template('Material');
                Import::View('MaterialLecturer',$data);
            }
        }
    }
    public function CompleteScheduleLoad(URI $URI, Input $Input) {
        $user = NULL;
        if($Input->Cookie()->GetValue('user')!=NULL)
            $user = $Input->Cookie()->GetValue('user');
        
		else if($Input->Session('EDU')->GetValue('user')!=NULL)
            $user = $Input->Session()->GetValue('user');
        else
           redirect($URI->ReturnURI('App=Home&Com=Session'));
		   
		   
        if($user != NULL)
        {
            if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $term = new Term();
                $termResult = $term->Equal('IsActive','Y')->First();
                $termBefore = $term->Equal('IsActive','N')->OrderBy('EndPeriode','DESC') ->First();
                $data = array();
                $lecturer = new Lecturer();
                $lectureSchedule = $lecturer->Join('Employee','Employee.EID','Lecturer.EID')->Equal('UName',$user->UName)
                        ->Join('TrLecturerToClass','TrLecturerToClass.LTID','Lecturer.LID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrLecturerToClass.TSCID')
                        ->Join('TrStudentSchedule','TrLecturerToClass.TSCID','TrStudentSchedule.TSCID')
                        ->Join('SchoolClass','SchoolClass.SCHID','TrHeaderStudentClass.SCHID')
                        ->Join('Subject','Subject.SUID','TrHeaderStudentClass.SUID')
                        ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                        ->Join('SchoolRoomClass','SchoolRoomClass.RCID','TrStudentSchedule.RCID')
                        ->Join('StudyShift','StudyShift.SSID','TrStudentSchedule.SSID')
                        ->Equal('TEID',$termResult->TEID)
                        ->OrderBy('TSSDate','DESC')
                        ->Get();
                $data['currentTerm'] = $termResult;
                $data['schedule'] = $lectureSchedule;
                Import::Template('Material');
                Import::View('CompleteScheduleLecturer',$data);
            }
        }
    }

    public function DetailSubjectLoad(URI $URI, Input $Input)
    {
       $user = NULL;
        if($Input->Cookie()->GetValue('user')!=NULL)
            $user = $Input->Cookie()->GetValue('user');
        
		else if($Input->Session('EDU')->GetValue('user')!=NULL)
            $user = $Input->Session()->GetValue('user');
        else
           redirect($URI->ReturnURI('App=Home&Com=Session'));
		   
		   
        if($user != NULL)
        {
            if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $param = $URI->GetURI();
                $term = new Term();
                $termResult = $term->Equal('IsActive','Y')->First();
                $termBefore = $term->Equal('IsActive','N')->OrderBy('EndPeriode','DESC') ->First();
                $data = array();
                $lecturer = new Lecturer();
                $param = $URI->GetURI();
                $sID = $param[3];
                $schID = $param[4];
                $term = new Term();
                $task = new Task();
                $termResult = $term->Equal('IsActive','Y')->First();
                $lectureResult = $lecturer->Join('Employee','Employee.EID','Lecturer.EID')->Equal('UName',$user->UName)
                        ->Join('TrLecturerToClass','TrLecturerToClass.LTID','Lecturer.LID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrLecturerToClass.TSCID')
                        ->Join('SchoolClass','SchoolClass.SCHID','TrHeaderStudentClass.SCHID')
                        ->Join('Subject','Subject.SUID','TrHeaderStudentClass.SUID')
                        ->Get();
                $lectureSchedule = $lecturer->Join('Employee','Employee.EID','Lecturer.EID')->Equal('UName',$user->UName)
                        ->Join('TrLecturerToClass','TrLecturerToClass.LTID','Lecturer.LID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrLecturerToClass.TSCID')
                        ->Join('TrStudentSchedule','TrLecturerToClass.TSCID','TrStudentSchedule.TSCID')
                        ->Join('SchoolClass','SchoolClass.SCHID','TrHeaderStudentClass.SCHID')
                        ->Join('Subject','Subject.SUID','TrHeaderStudentClass.SUID')
                        ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                        ->Join('SchoolRoomClass','SchoolRoomClass.RCID','TrStudentSchedule.RCID')
                        ->Join('StudyShift','StudyShift.SSID','TrStudentSchedule.SSID')
                        ->Equal('TEID',$termResult->TEID)
                        ->Equal('TSSDate',date('Y-m-d',time()))
                        ->OrderBy('TSSDate','DESC')
                        ->Get();
                $detailMP = $lecturer->Join('Employee','Employee.EID','Lecturer.EID')->Equal('UName',$user->UName)
                        ->Join('TrLecturerToClass','TrLecturerToClass.LTID','Lecturer.LID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrLecturerToClass.TSCID')
                        ->Join('TrStudentSchedule','TrLecturerToClass.TSCID','TrStudentSchedule.TSCID')
                        ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                        ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                        ->Join('SAP','SAP.SAPID','MP.SAPID')
                        ->Equal('TEID',$termResult->TEID)
                        ->Equal('Subject.SUID',$sID)
                        ->Equal('TrHeaderStudentClass.SCHID',$schID)
                        ->OrderBy('AttnNumber','ASC')->Get();
                $addtionalMaterial = $lecturer->Join('Employee','Employee.EID','Lecturer.EID')->Equal('UName',$user->UName)
                        ->Join('TrLecturerToClass','TrLecturerToClass.LTID','Lecturer.LID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrLecturerToClass.TSCID')
                        ->Join('TrStudentSchedule','TrLecturerToClass.TSCID','TrStudentSchedule.TSCID')
                        ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                        ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                        ->Join('SAP','SAP.SAPID','MP.SAPID')
                        ->Join('AdditionalMateri','AdditionalMateri.TSCID','TrHeaderStudentClass.TSCID')
                        ->Equal('TEID',$termResult->TEID)
                        ->Equal('Subject.SUID',$sID)
                        ->Equal('TrHeaderStudentClass.SCHID',$schID)
                        ->OrderBy('AttnNumber','ASC')->Get();
                if(empty($detailMP))
                {
                    redirect($URI->ReturnURI('App=Class&Com=MaterialLecture'));
                    exit();
                }
                $firstMP = $detailMP[0];
                $lo = new LO();
                $book = new ReferenceBook();
                $resultLO = $lo->Equal('SAPID',$firstMP->SAPID)->Get();
                $arrMPID = array();
                foreach($detailMP as $itemMP)
                {
                    array_push($arrMPID,$itemMP->MPID);
                }
                $resultBook = $book->In('MPID',$arrMPID)->Get();

                $taskDetail = $task->Join('MP','MP.MPID','Task.MPID')
                        ->Join('TrHeaderTaskForStudent','TrHeaderTaskForStudent.TID','Task.TID')
                        ->Equal('TSCID',$firstMP->TSCID)
                        ->In('Task.MPID',$arrMPID)->OrderBy('AttnNumber','DESC')->Get();

                $data['detailMP']=$detailMP;
                $data['resultLO'] = $resultLO;
                $data['nextSchedule'] = $lectureSchedule;
                $data['schedule'] = $lectureResult;
                $data['resultBook'] = $resultBook;
                $data['currentTerm'] = $termResult;
                $data['currentMP'] = $param[3].'/'.$param[4];
                $data['detailTask'] = $taskDetail;
                $data['addtionalMaterial'] = $addtionalMaterial;
                Import::Template('Material');
                Import::View('DetailMaterialLecturer',$data);
            }
        }
    }

    public function AddMaterialLoad(URI $URI, Input $Input)
    {
       $user = NULL;
        if($Input->Cookie()->GetValue('user')!=NULL)
            $user = $Input->Cookie()->GetValue('user');
        
		else if($Input->Session('EDU')->GetValue('user')!=NULL)
            $user = $Input->Session()->GetValue('user');
        else
           redirect($URI->ReturnURI('App=Home&Com=Session'));
		   
        if($user != NULL)
        {
            if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $param = $URI->GetURI();
                $term = new Term();
                $termResult = $term->Equal('IsActive','Y')->First();
                $termBefore = $term->Equal('IsActive','N')->OrderBy('EndPeriode','DESC') ->First();
                $data = array();
                $lecturer = new Lecturer();
                $param = $URI->GetURI();
                $tscID = $param[3];
                $term = new Term();
                $termResult = $term->Equal('IsActive','Y')->First();
                $detailMP = $lecturer->Join('Employee','Employee.EID','Lecturer.EID')->Equal('UName',$user->UName)
                        ->Join('TrLecturerToClass','TrLecturerToClass.LTID','Lecturer.LID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrLecturerToClass.TSCID')
                        ->Join('TrStudentSchedule','TrLecturerToClass.TSCID','TrStudentSchedule.TSCID')
                        ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                        ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                        ->Join('SAP','SAP.SAPID','MP.SAPID')
                        ->Equal('TEID',$termResult->TEID)
                        ->Equal('TrHeaderStudentClass.TSCID',$tscID)
                        ->OrderBy('AttnNumber','ASC')->Get();
                $data['detailMP']=$detailMP;
                $data['firstMP']=$detailMP[0];
                $data['tscID'] = $tscID;
                $data['currentTerm'] = $termResult;
                Import::Template('Material');
                Import::View('AddMaterialLecture',$data);
            }
        }
    }

    public function UploadMaterialLoad(URI $URI, Input $Input)
    {
        $user = NULL;
        if($Input->Cookie()->GetValue('user')!=NULL)
            $user = $Input->Cookie()->GetValue('user');
        
		else if($Input->Session('EDU')->GetValue('user')!=NULL)
            $user = $Input->Session()->GetValue('user');
        else
           redirect($URI->ReturnURI('App=Home&Com=Session'));
		   
		   
        if($user != NULL)
        {
            if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $lecture = new Lecturer();
                $addMateri = new AdditionalMateri();
                $addMateriData = new AdditionalMateriEntity();
                $TSCID = $Input->Post('TSCID');
                $MPID = $Input->Post('mpid');
                $lectureData = $lecture->Join('Employee','Employee.EID','Lecturer.EID')->Equal('UName',$user->UName)->First();
                $fileMaterial = $_FILES['fileMaterial'];

                $addMateriData->TSCID = $TSCID;
                $addMateriData->MPID = $MPID;
                $addMateriData->LTID = $lectureData->LID;

                $sourceFolder = Config::Instance(SETTING_USE)->documentRoot.'/File/Download/MP/';

                if(! file_exists($sourceFolder))
                {
                    mkdir ( $sourceFolder , 0777 , true);
                }
                $fileName = $fileMaterial['name'];
                $fileParse = explode('.',$fileName);
                $fileExt = $fileParse[count($fileParse)-1];
                $fileName = time().'_'.$MPID.'_'.$lectureData->LID.'.'.$fileExt;

                $destination = $sourceFolder.$fileName;

                if(move_uploaded_file($fileMaterial['tmp_name'], $destination)) {
                    $addMateriData->FilePath = $fileName;
                    $addMateriData->UploadTime = date('Y-m-d H:i:s',time());
                    $addMateri->Add($addMateriData);
                }
                redirect($URI->ReturnURI('App=Class&Com=MaterialLecture'));
            }
        }
    }

    public function UploadTaskLoad(URI $URI, Input $Input)
    {
        $user = NULL;
        if($Input->Cookie()->GetValue('user')!=NULL)
            $user = $Input->Cookie()->GetValue('user');
        
		else if($Input->Session('EDU')->GetValue('user')!=NULL)
            $user = $Input->Session()->GetValue('user');
        else
           redirect($URI->ReturnURI('App=Home&Com=Session'));
		   
		   
        if($user != NULL)
        {
            if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $lecture = new Lecturer();
                $addTask = new Task();
                $addTaskData = new TaskEntity();
                $taskHeader = new TrHeaderTaskForStudent();
                $taskHeaderData = new TrHeaderTaskForStudentEntity();
                $TSCID = $Input->Post('TSCID');
                $MPID = $Input->Post('mpid');
                $tname = $Input->Post('tname');
                $tdesc = $Input->Post('tdesc');
                $deadline = $Input->Post('deadline');

                $lectureData = $lecture->Join('Employee','Employee.EID','Lecturer.EID')->Equal('UName',$user->UName)->First();
                $fileMaterial = $_FILES['fileTask'];
                $fileAnswer = $_FILES['fileAnswer'];

                $addTaskData->MPID = $MPID;
                $addTaskData->TName = $tname;
                $addTaskData->TDesc = $tdesc;
                $addTaskData->TStatus = 'Additional';

                $taskHeaderData->TSCID = $TSCID;
                $deadlineparse = explode('/',$deadline);
                $taskHeaderData->Deadline = $deadlineparse[2].'-'.$deadlineparse[0].'-'.$deadlineparse[1];
                $taskHeaderData->LTID = $lectureData->LID;

                $sourceFolder = Config::Instance(SETTING_USE)->documentRoot.'/File/Download/Task/';

                if(! file_exists($sourceFolder))
                {
                    mkdir ( $sourceFolder , 0777 , true);
                }
                $fileName = $fileMaterial['name'];
                $fileParse = explode('.',$fileName);
                $fileExt = $fileParse[count($fileParse)-1];
                $fileName = time().'_'.$MPID.'_'.$lectureData->LID.'.'.$fileExt;

                $destination = $sourceFolder.$fileName;

                if(move_uploaded_file($fileMaterial['tmp_name'], $destination)) {
                    $addTaskData->TFilePath = $fileName;
                    $addTask->Add($addTaskData);
                    $tid = $addTask->GetLastInsertID();
                    $taskHeaderData->TID = $tid;
                    $taskHeader->Add($taskHeaderData);

                    if($fileAnswer['name'] != '')
                    {
                        $answerSourceFolder = Config::Instance(SETTING_USE)->documentRoot.'/File/Download/TaskAnswer/';
                        if(! file_exists($answerSourceFolder))
                        {
                            mkdir ( $answerSourceFolder , 0777 , true);
                        }
                        $fileName = $fileAnswer['name'];
                        $fileParse = explode('.',$fileName);
                        $fileExt = $fileParse[count($fileParse)-1];
                        $fileName = time().'_'.$MPID.'_'.$lectureData->LID.'.'.$fileExt;
                        $destination = $answerSourceFolder.$fileName;
                        if(move_uploaded_file($fileAnswer['tmp_name'], $destination)) {
                            $tanswer = new TaskAnswer();
                            $tanswerData = new TaskAnswerEntity();
                            $tanswerData->TAFilePath = $fileName;
                            $tanswerData->TID = $tid;
                            $tanswer->Add($tanswerData);
                        }
                    }
                }
                redirect($URI->ReturnURI('App=Class&Com=MaterialLecture'));
            }
        }
    }

    public function EditMaterialLoad(URI $URI, Input $Input)
    {
        $user = NULL;
        if($Input->Cookie()->GetValue('user')!=NULL)
            $user = $Input->Cookie()->GetValue('user');
        
		else if($Input->Session('EDU')->GetValue('user')!=NULL)
            $user = $Input->Session()->GetValue('user');
        else
           redirect($URI->ReturnURI('App=Home&Com=Session'));
		   
		   
		   
        if($user != NULL)
        {
            if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $param = $URI->GetURI();
                $term = new Term();
                $termResult = $term->Equal('IsActive','Y')->First();
                $termBefore = $term->Equal('IsActive','N')->OrderBy('EndPeriode','DESC') ->First();
                $data = array();
                $lecturer = new Lecturer();
                $param = $URI->GetURI();
                $AMID = $param[3];
                $term = new Term();
                $termResult = $term->Equal('IsActive','Y')->First();
                $am = new AdditionalMateri();
                $firstAM = $am->Equal('AMID',$AMID)->First();
                $detailMP = $lecturer->Join('Employee','Employee.EID','Lecturer.EID')->Equal('UName',$user->UName)
                        ->Join('TrLecturerToClass','TrLecturerToClass.LTID','Lecturer.LID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrLecturerToClass.TSCID')
                        ->Join('TrStudentSchedule','TrLecturerToClass.TSCID','TrStudentSchedule.TSCID')
                        ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                        ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                        ->Join('SAP','SAP.SAPID','MP.SAPID')
                        ->Equal('TrHeaderStudentClass.TSCID',$firstAM->TSCID)
                        ->Equal('TEID',$termResult->TEID)
                        ->OrderBy('AttnNumber','ASC')->Get();
                $data['detailMP']=$detailMP;
                $data['firstMP']=$detailMP[0];
                $data['firstAM']=$firstAM;
                $data['AMID'] = $AMID;
                $data['currentTerm'] = $termResult;
                Import::Template('Material');
                Import::View('EditMaterialLecture',$data);
            }
        }
    }

    public function EditTaskLoad(URI $URI,Input $Input){
        $user = NULL;
        if($Input->Cookie()->GetValue('user')!=NULL)
            $user = $Input->Cookie()->GetValue('user');
        
		else if($Input->Session('EDU')->GetValue('user')!=NULL)
            $user = $Input->Session()->GetValue('user');
        else
           redirect($URI->ReturnURI('App=Home&Com=Session'));
		   
		   
        if($user != NULL)
        {
            if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $param = $URI->GetURI();
                $term = new Term();
                $termResult = $term->Equal('IsActive','Y')->First();
                $termBefore = $term->Equal('IsActive','N')->OrderBy('EndPeriode','DESC') ->First();
                $data = array();
                $lecturer = new Lecturer();
                $param = $URI->GetURI();
                $taskID = $param[3];
                $term = new Term();
                $task = new Task();

                $currentTask = $task->Equal('Task.TID',$taskID)->LeftJoin('TaskAnswer','TaskAnswer.TID','Task.TID')
                        ->Join('TrHeaderTaskForStudent','TrHeaderTaskForStudent.TID','Task.TID')
                        ->First();
                $termResult = $term->Equal('IsActive','Y')->First();
                $detailMP = $lecturer->Join('Employee','Employee.EID','Lecturer.EID')->Equal('UName',$user->UName)
                        ->Join('TrLecturerToClass','TrLecturerToClass.LTID','Lecturer.LID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrLecturerToClass.TSCID')
                        ->Join('TrStudentSchedule','TrLecturerToClass.TSCID','TrStudentSchedule.TSCID')
                        ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                        ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                        ->Join('SAP','SAP.SAPID','MP.SAPID')
                        ->Equal('TEID',$termResult->TEID)
                        ->Equal('TrHeaderStudentClass.TSCID',$currentTask->TSCID)
                        ->OrderBy('AttnNumber','ASC')->Get();
                $data['detailMP']=$detailMP;
                $data['firstMP']=$detailMP[0];
                $data['currentTask'] = $currentTask;
                $data['currentTerm'] = $termResult;
                Import::Template('Material');
                Import::View('EditTaskLecture',$data);
            }
        }
    }

    public function DeleteTaskLoad(URI $URI,Input $Input)
    {
        $user = NULL;
        if($Input->Cookie()->GetValue('user')!=NULL)
            $user = $Input->Cookie()->GetValue('user');
        
		else if($Input->Session('EDU')->GetValue('user')!=NULL)
            $user = $Input->Session()->GetValue('user');
        else
           redirect($URI->ReturnURI('App=Home&Com=Session'));
		   
		   
        if($user != NULL)
        {
            if($user->UType == 'Student')
                echo 'res = '.json_encode(array('type'=>'failed'));
            else if($user->UType == 'Guardian')
                echo 'res = '.json_encode(array('type'=>'failed'));
            else
            {
                $TID = $Input->Post('TID');
                $tanswer = new TaskAnswer();
                $tanswerData = $tanswer->Equal('TID',$TID)->Get();
                $tanswer->Delete($tanswerData);
                $thTaskForStudent = new TrHeaderTaskForStudent();
                $thTaskForStudentData = $thTaskForStudent->Equal('TID',$TID)->Get();

                $thtsid = array();
                foreach($thTaskForStudentData as $thtsdItem)
                {
                    array_push($thtsid,$thtsdItem->THTSID);
                }

                $tdTaskForStudent = new TrDetailTaskForStudent();
                $tdTaskForStudentData = $tdTaskForStudent->In('THTSID',$thtsid)->Get();
                $tdTaskForStudent->Delete($tdTaskForStudentData);

                $thTaskForStudent->Delete($thTaskForStudentData);

                echo 'res = '.json_encode(array('type'=>'success'));
            }
        }
    }

    public function DeleteMaterialLoad(URI $URI,Input $Input)
    {
        $user = NULL;
        if($Input->Cookie()->GetValue('user')!=NULL)
            $user = $Input->Cookie()->GetValue('user');
        
		else if($Input->Session('EDU')->GetValue('user')!=NULL)
            $user = $Input->Session()->GetValue('user');
        else
           redirect($URI->ReturnURI('App=Home&Com=Session'));
		   
		   
        if($user != NULL)
        {
            if($user->UType == 'Student')
                echo 'res = '.json_encode(array('type'=>'failed'));
            else if($user->UType == 'Guardian')
                echo 'res = '.json_encode(array('type'=>'failed'));
            else
            {
                $AMID = $Input->Post('AMID');
                $addMateri = new AdditionalMateri();
                $addMateriData = $addMateri->Equal('AMID',$AMID)->First();
                $addMateri->Delete($addMateriData);
                echo 'res = '.json_encode(array('type'=>'success'));
            }
        }
    }

    public function EditActionMaterialLoad(URI $URI,Input $Input)
    {
        $user = NULL;
        if($Input->Cookie()->GetValue('user')!=NULL)
            $user = $Input->Cookie()->GetValue('user');
        
		else if($Input->Session('EDU')->GetValue('user')!=NULL)
            $user = $Input->Session()->GetValue('user');
        else
           redirect($URI->ReturnURI('App=Home&Com=Session'));
		   
		   
        if($user != NULL)
        {
            if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $lecture = new Lecturer();
                $addMateri = new AdditionalMateri();
                $AMID = $Input->Post('AMID');
                $MPID = $Input->Post('mpid');
                
                $lectureData = $lecture->Join('Employee','Employee.EID','Lecturer.EID')->Equal('Employee.UName',$user->UName)->First();
                $addMateriData = $addMateri->Equal('AMID',$AMID)->First();
                $fileMaterial = $_FILES['fileMaterial'];
                $addMateriData->MPID = $MPID;

                if($fileMaterial['name'] != '')
                {
                    $sourceFolder = Config::Instance(SETTING_USE)->documentRoot.'/File/Download/MP/';

                    if(! file_exists($sourceFolder))
                    {
                        mkdir ( $sourceFolder , 0777 , true);
                    }
                    $fileName = $fileMaterial['name'];
                    $fileParse = explode('.',$fileName);
                    $fileExt = $fileParse[count($fileParse)-1];
                    $fileName = time().'_'.$MPID.'_'.$lectureData->LID.'.'.$fileExt;

                    $destination = $sourceFolder.$fileName;

                    if(move_uploaded_file($fileMaterial['tmp_name'], $destination)) {
                        $addMateriData->FilePath = $fileName;
                        $addMateriData->UploadTime = date('Y-m-d H:i:s',time());
                    }
                }
                $addMateri->Update($addMateriData);
                redirect($URI->ReturnURI('App=Class&Com=MaterialLecture'));
            }
        }
    }

    public function AddTaskLoad(URI $URI, Input $Input)
    {
        $user = NULL;
        if($Input->Cookie()->GetValue('user')!=NULL)
            $user = $Input->Cookie()->GetValue('user');
        
		else if($Input->Session('EDU')->GetValue('user')!=NULL)
            $user = $Input->Session()->GetValue('user');
        else
           redirect($URI->ReturnURI('App=Home&Com=Session'));
		   
		   
        if($user != NULL)
        {
            if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $param = $URI->GetURI();
                $term = new Term();
                $termResult = $term->Equal('IsActive','Y')->First();
                $termBefore = $term->Equal('IsActive','N')->OrderBy('EndPeriode','DESC') ->First();
                $data = array();
                $lecturer = new Lecturer();
                $param = $URI->GetURI();
                $tscID = $param[3];
                $term = new Term();
                $termResult = $term->Equal('IsActive','Y')->First();
                $detailMP = $lecturer->Join('Employee','Employee.EID','Lecturer.EID')->Equal('UName',$user->UName)
                        ->Join('TrLecturerToClass','TrLecturerToClass.LTID','Lecturer.LID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrLecturerToClass.TSCID')
                        ->Join('TrStudentSchedule','TrLecturerToClass.TSCID','TrStudentSchedule.TSCID')
                        ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                        ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                        ->Join('SAP','SAP.SAPID','MP.SAPID')
                        ->Equal('TEID',$termResult->TEID)
                        ->Equal('TrHeaderStudentClass.TSCID',$tscID)
                        ->OrderBy('AttnNumber','ASC')->Get();
                $data['detailMP']=$detailMP;
                $data['firstMP']=$detailMP[0];
                $data['tscID'] = $tscID;
                $data['currentTerm'] = $termResult;
                Import::Template('Material');
                Import::View('AddTaskLecture',$data);
            }
        }
    }

    public function DownloadMaterialLoad(URI $URI, Input $Input)
    {
       $user = NULL;
        if($Input->Cookie()->GetValue('user')!=NULL)
            $user = $Input->Cookie()->GetValue('user');
        
		else if($Input->Session('EDU')->GetValue('user')!=NULL)
            $user = $Input->Session()->GetValue('user');
        else
           redirect($URI->ReturnURI('App=Home&Com=Session'));
		   
		   
        if($user != NULL)
        {
            if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $param = $URI->GetURI();
                $term = new Term();
                $termResult = $term->Equal('IsActive','Y')->First();
                $termBefore = $term->Equal('IsActive','N')->OrderBy('EndPeriode','DESC') ->First();
                $data = array();
                $lecturer = new Lecturer();
                $param = $URI->GetURI();
                $sID = $param[3];


                $detailMP = $lecturer->Join('Employee','Employee.EID','Lecturer.EID')->Equal('UName',$user->UName)
                        ->Join('TrLecturerToClass','TrLecturerToClass.LTID','Lecturer.LID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrLecturerToClass.TSCID')
                        ->Join('TrStudentSchedule','TrLecturerToClass.TSCID','TrStudentSchedule.TSCID')
                        ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                        ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                        ->Join('SAP','SAP.SAPID','MP.SAPID')
                        ->Equal('TEID',$termResult->TEID)
                        ->Equal('Subject.SUID',$sID)
                        ->Equal('MP.MPID',$param[3])
                        ->OrderBy('AttnNumber','ASC')->First();
                if($detailMP != null)
                {
                    if($detailMP->MaterialPath != '')
                    {
                        $sourceFolder = Config::Instance(SETTING_USE)->documentRoot.'/File/Download/MP/';
                        $fileParse = explode('.',$detailMP->MaterialPath);
                        $fileExt = $fileParse[count($fileParse)-1];
                        $fileName = $detailMP->SubjectTitle.'.'.$fileExt;
                        File::DownloadFile($sourceFolder,$detailMP->MaterialPath,$fileName);
                    }
                    else
                        echo "<script>history.back();</script>";
                }
                else
                    echo "<script>history.back();</script>";
            }
        }
    }

    public function DownloadAdditionalMaterialLoad(URI $URI, Input $Input)
    {
       $user = NULL;
        if($Input->Cookie()->GetValue('user')!=NULL)
            $user = $Input->Cookie()->GetValue('user');
        
		else if($Input->Session('EDU')->GetValue('user')!=NULL)
            $user = $Input->Session()->GetValue('user');
        else
           redirect($URI->ReturnURI('App=Home&Com=Session'));
		   
		   
        if($user != NULL)
        {
            if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $param = $URI->GetURI();
                $term = new Term();
                $termResult = $term->Equal('IsActive','Y')->First();
                $termBefore = $term->Equal('IsActive','N')->OrderBy('EndPeriode','DESC') ->First();
                $data = array();
                $lecturer = new Lecturer();
                $param = $URI->GetURI();

                $addtionalMaterial = $lecturer->Join('Employee','Employee.EID','Lecturer.EID')->Equal('UName',$user->UName)
                        ->Join('TrLecturerToClass','TrLecturerToClass.LTID','Lecturer.LID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrLecturerToClass.TSCID')
                        ->Join('TrStudentSchedule','TrLecturerToClass.TSCID','TrStudentSchedule.TSCID')
                        ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                        ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                        ->Join('SAP','SAP.SAPID','MP.SAPID')
                        ->Join('AdditionalMateri','AdditionalMateri.TSCID','TrHeaderStudentClass.TSCID')
                        ->Equal('TEID',$termResult->TEID)
                        ->Equal('AdditionalMateri.AMID',$param[3])
                        ->OrderBy('AttnNumber','ASC')->First();
                
                if($addtionalMaterial != null)
                {
                    if($addtionalMaterial->FilePath != '')
                    {
                        $sourceFolder = Config::Instance(SETTING_USE)->documentRoot.'/File/Download/MP/';
                        $fileParse = explode('.',$addtionalMaterial->FilePath);
                        $fileExt = $fileParse[count($fileParse)-1];
                        $fileName = 'Additional_Material_'.$addtionalMaterial->AMID.'_'.$addtionalMaterial->SubjectTitle.'.'.$fileExt;
                        File::DownloadFile($sourceFolder,$addtionalMaterial->FilePath,$fileName);
                    }
                    else
                        echo "<script>history.back();</script>";
                }
                else
                    echo "<script>history.back();</script>";
            }
        }
    }

    public function DownloadTaskLoad(URI $URI, Input $Input)
    {
        $user = NULL;
        if($Input->Cookie()->GetValue('user')!=NULL)
            $user = $Input->Cookie()->GetValue('user');
        
		else if($Input->Session('EDU')->GetValue('user')!=NULL)
            $user = $Input->Session()->GetValue('user');
        else
           redirect($URI->ReturnURI('App=Home&Com=Session'));
		   
		   
		   
        if($user != NULL)
        {
            if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $param = $URI->GetURI();
                $term = new Term();
                $task = new Task();
                $termResult = $term->Equal('IsActive','Y')->First();
                $lecturer = new Lecturer();
                $listClassID = $lecturer->Join('Employee','Employee.EID','Lecturer.EID')->Equal('UName',$user->UName)
                        ->Join('TrLecturerToClass','TrLecturerToClass.LTID','Lecturer.LID')->Get();

                $arrayTSCID = array();
                foreach($listClassID as $classItem){
                    array_push($arrayTSCID,$classItem->TSCID);
                };

                $taskDetail = $task->Join('MP','MP.MPID','Task.MPID')
                        ->Join('TrHeaderTaskForStudent','TrHeaderTaskForStudent.TID','Task.TID')
                        ->In('TSCID',$arrayTSCID)
                        ->Equal('Task.TID',$param[3])->First();

                if($taskDetail != null)
                {
                    if($taskDetail->TFilePath != '')
                    {
                        $sourceFolder = Config::Instance(SETTING_USE)->documentRoot.'/File/Download/Task/';
                        $fileParse = explode('.',$taskDetail->TFilePath);
                        $fileExt = $fileParse[count($fileParse)-1];
                        $fileName = $taskDetail->TName.'.'.$fileExt;
                        File::DownloadFile($sourceFolder,$taskDetail->TFilePath,$fileName);
                    }
                    else
                        echo "<script>history.back();</script>";
                }
                else
                    echo "<script>history.back();</script>";
            }
        }
    }
    public function DownloadTaskAnswerLoad(URI $URI, Input $Input)
    {
        $user = NULL;
        if($Input->Cookie()->GetValue('user')!=NULL)
            $user = $Input->Cookie()->GetValue('user');
        
		else if($Input->Session('EDU')->GetValue('user')!=NULL)
            $user = $Input->Session()->GetValue('user');
        else
           redirect($URI->ReturnURI('App=Home&Com=Session'));
		   
		   
        if($user != NULL)
        {
            if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $param = $URI->GetURI();
                $term = new Term();
                $task = new Task();
                $termResult = $term->Equal('IsActive','Y')->First();
                $lecturer = new Lecturer();
                $listClassID = $lecturer->Join('Employee','Employee.EID','Lecturer.EID')->Equal('UName',$user->UName)
                        ->Join('TrLecturerToClass','TrLecturerToClass.LTID','Lecturer.LID')->Get();

                $arrayTSCID = array();
                foreach($listClassID as $classItem){
                    array_push($arrayTSCID,$classItem->TSCID);
                };

                $taskDetail = $task->Join('MP','MP.MPID','Task.MPID')
                        ->Join('TrHeaderTaskForStudent','TrHeaderTaskForStudent.TID','Task.TID')
                        ->LeftJoin('TaskAnswer','TaskAnswer.TID','Task.TID')
                        ->In('TSCID',$arrayTSCID)
                        ->Equal('TaskAnswer.TAID',$param[3])->First();

                if($taskDetail != null)
                {
                    if($taskDetail->TAFilePath != '')
                    {
                        $sourceFolder = Config::Instance(SETTING_USE)->documentRoot.'/File/Download/TaskAnswer/';
                        $fileParse = explode('.',$taskDetail->TAFilePath);
                        $fileExt = $fileParse[count($fileParse)-1];
                        $fileName = 'Answer_'.$taskDetail->TName.'.'.$fileExt;
                        File::DownloadFile($sourceFolder,$taskDetail->TAFilePath,$fileName);
                    }
                    else
                        echo "<script>history.back();</script>";
                }
                else
                    echo "<script>history.back();</script>";
            }
        }
    }

    public function UploadEditTaskLoad(URI $URI, Input $Input)
    {
        $user = NULL;
        if($Input->Cookie()->GetValue('user')!=NULL)
            $user = $Input->Cookie()->GetValue('user');
        
		else if($Input->Session('EDU')->GetValue('user')!=NULL)
            $user = $Input->Session()->GetValue('user');
        else
           redirect($URI->ReturnURI('App=Home&Com=Session'));
		   
		   
		   
        if($user != NULL)
        {
            if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $lecture = new Lecturer();
                $addTask = new Task();
                $taskHeader = new TrHeaderTaskForStudent();
                $tanswer = new TaskAnswer();
                $TID = $Input->Post('TID');
                $MPID = $Input->Post('mpid');
                $tname = $Input->Post('tname');
                $tdesc = $Input->Post('tdesc');
                $deadline = $Input->Post('deadline');


                $lectureData = $lecture->Join('Employee','Employee.EID','Lecturer.EID')->Equal('UName',$user->UName)->First();
                $currentTask = $addTask->Equal('Task.TID',$TID)->First();
                $currentTaskAnswer = $tanswer->Equal('TID',$TID)->First();
                $currentTaskHeader = $taskHeader->Equal('TID',$TID)->First();
                $fileMaterial = $_FILES['fileTask'];
                $fileAnswer = $_FILES['fileAnswer'];

                $currentTask->MPID = $MPID;
                $currentTask->TName = $tname;
                $currentTask->TDesc = $tdesc;
                $currentTask->TStatus = 'Additional';

                $deadlineparse = explode('/',$deadline);
                $currentTaskHeader->Deadline = $deadlineparse[2].'-'.$deadlineparse[0].'-'.$deadlineparse[1];
                $currentTaskHeader->LTID = $lectureData->LID;

                $sourceFolder = Config::Instance(SETTING_USE)->documentRoot.'/File/Download/Task/';

                if(! file_exists($sourceFolder))
                {
                    mkdir ( $sourceFolder , 0777 , true);
                }
                $fileName = $fileMaterial['name'];
                $fileParse = explode('.',$fileName);
                $fileExt = $fileParse[count($fileParse)-1];
                $fileName = time().'_'.$MPID.'_'.$lectureData->LID.'.'.$fileExt;

                $destination = $sourceFolder.$fileName;

                if(move_uploaded_file($fileMaterial['tmp_name'], $destination)) {
                    $currentTask->TFilePath = $fileName;
                }
                $addTask->Update($currentTask);
                $taskHeader->Update($currentTaskHeader);

                if($fileAnswer['name'] != '')
                {
                    $answerSourceFolder = Config::Instance(SETTING_USE)->documentRoot.'/File/Download/TaskAnswer/';
                    if(! file_exists($answerSourceFolder))
                    {
                        mkdir ( $answerSourceFolder , 0777 , true);
                    }
                    $fileName = $fileAnswer['name'];
                    $fileParse = explode('.',$fileName);
                    $fileExt = $fileParse[count($fileParse)-1];
                    $fileName = time().'_'.$MPID.'_'.$lectureData->LID.'.'.$fileExt;
                    $destination = $answerSourceFolder.$fileName;
                    if(move_uploaded_file($fileAnswer['tmp_name'], $destination)) {
                        $currentTaskAnswer->TAFilePath = $fileName;
                        $tanswer->Update($currentTaskAnswer);
                    }
                }
                redirect($URI->ReturnURI('App=Class&Com=MaterialLecture'));
            }
        }
    }

    public function GetAnswerLoad(URI $URI, Input $Input)
    {
        $user = NULL;
        if($Input->Cookie()->GetValue('user')!=NULL)
            $user = $Input->Cookie()->GetValue('user');
        
		else if($Input->Session('EDU')->GetValue('user')!=NULL)
            $user = $Input->Session()->GetValue('user');
        else
           redirect($URI->ReturnURI('App=Home&Com=Session'));
		   
		   
        if($user != NULL)
        {
            if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $param = $URI->GetURI();
                $TID = $param[3];
                $task = new Task();
                $studentAnswer = $task->Equal('Task.TID',$TID)
                        ->Join('TrHeaderTaskForStudent','TrHeaderTaskForStudent.TID','Task.TID')
                        ->Join('Lecturer','TrHeaderTaskForStudent.LTID','Lecturer.LID')
                        ->Join('Employee','Employee.EID','Lecturer.EID')
                        ->Equal('Employee.UName',$user->UName)
                        ->LeftJoin('TrDetailTaskForStudent','TrDetailTaskForStudent.THTSID','TrHeaderTaskForStudent.THTSID')
                        ->Join('TrDetailStudentClass','TrDetailStudentClass.TSCID','TrHeaderTaskForStudent.TSCID')
                        ->Join('Student','Student.STID','TrDetailStudentClass.STID')
                        ->Get();
                $data['studentAnswer'] = $studentAnswer;
                Import::Template('Material');
                Import::View('GetAnswer',$data);
            }
        }
    }

    public function DownloadStudentAnswerLoad(URI $URI, Input $Input)
    {
        $user = NULL;
        if($Input->Cookie()->GetValue('user')!=NULL)
            $user = $Input->Cookie()->GetValue('user');
        
		else if($Input->Session('EDU')->GetValue('user')!=NULL)
            $user = $Input->Session()->GetValue('user');
        else
           redirect($URI->ReturnURI('App=Home&Com=Session'));
		   
		   
		   
        if($user != NULL)
        {
            if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $param = $URI->GetURI();
                $answerID = $param[3];
                $task = new Task();
                $studentAnswer = $task->Join('TrHeaderTaskForStudent','TrHeaderTaskForStudent.TID','Task.TID')
                        ->Join('Lecturer','TrHeaderTaskForStudent.LTID','Lecturer.LID')
                        ->Join('Employee','Employee.EID','Lecturer.EID')
                        ->Equal('Employee.UName',$user->UName)
                        ->Join('TrDetailTaskForStudent','TrDetailTaskForStudent.THTSID','TrHeaderTaskForStudent.THTSID')
                        ->Join('TrDetailStudentClass','TrDetailStudentClass.TSCID','TrHeaderTaskForStudent.TSCID')
                        ->Join('Student','Student.STID','TrDetailStudentClass.STID')
                        ->Equal('TrHeaderTaskForStudent.THTSID',$answerID)
                        ->First();
                if($studentAnswer->THTSFilePath != '')
                {
                    if($studentAnswer->THTSFilePath != '')
                    {
                        $sourceFolder = Config::Instance(SETTING_USE)->documentRoot.'/File/Upload/Answer/'.$studentAnswer->STCode.'/';
                        $fileParse = explode('.',$studentAnswer->THTSFilePath);
                        $fileExt = $fileParse[count($fileParse)-1];
                        $fileName = 'Answer_'.$studentAnswer->STCode.'_'.$studentAnswer->TName.'.'.$fileExt;
                        File::DownloadFile($sourceFolder,$studentAnswer->THTSFilePath,$fileName);
                    }
                    else
                        echo "<script>history.back();</script>";
                }
                else
                    echo "<script>history.back();</script>";
            }
        }
    }
    public function PostStudentAnswerLoad(URI $URI, Input $Input)
    {
        $user = NULL;
        if($Input->Cookie()->GetValue('user')!=NULL)
            $user = $Input->Cookie()->GetValue('user');
        
		else if($Input->Session('EDU')->GetValue('user')!=NULL)
            $user = $Input->Session()->GetValue('user');
        else
           redirect($URI->ReturnURI('App=Home&Com=Session'));
		   
		   
		   
        if($user != NULL)
        {
            if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $idTHTS = $Input->Post('idTHTS');
                $idTHTSParse = explode(',',$idTHTS);
                $tdStudentAnswer = new TrDetailTaskForStudent();
                foreach($idTHTSParse as $idItem)
                {
                    $score = $Input->Post('answer_'.$idItem);
                    $tdStudentAnswerData = $tdStudentAnswer->Equal('THTSID',$idItem)->First();
                    $tdStudentAnswerData->Score = $score;
                    $tdStudentAnswerData->Checked = 'y';
                    $tdStudentAnswer->Update($tdStudentAnswerData);
                }
                redirect($URI->ReturnURI('App=Class&Com=MaterialLecture'));
            }
        }
    }
}
