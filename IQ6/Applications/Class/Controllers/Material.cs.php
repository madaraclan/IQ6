<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');

class _Material extends Controller {

    public function __construct()
    {
        Import::Model("class.Student");
        Import::Model("class.Term");
        Import::Model("class.SchoolGrade");
        Import::Model("class.Task");
        Import::Model("class.LO");
        Import::Model("class.ReferenceBook");
        Import::Entity("class.TrDetailTaskForStudent");
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
            if($user->UType == 'Lecture')
                redirect($URI->ReturnURI('App=Class&Com=MaterialLecture'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $term = new Term();
                $termResult = $term->Equal('IsActive','Y')->First();
                $termBefore = $term->Equal('IsActive','N')->OrderBy('EndPeriode','DESC') ->First();
                $student = new Student();
                $schoolID = $student->Equal('UName',$user->UName)->First()->CPID;
                $resultStudent = $student->Equal('UName',$user->UName)->Join('TrDetailStudentClass','TrDetailStudentClass.STID','Student.STID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrDetailStudentClass.TSCID')
                        ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                        ->Equal('TEID',$termResult->TEID)
                        ->OrderBy('SCCode')->Get();
                $resultScore = $student->Equal('UName',$user->UName)->Join('TrDetailScore','TrDetailScore.STID','Student.STID')
                        ->Join('TrHeaderScore','TrHeaderScore.THSOID','TrDetailScore.THSOID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrHeaderScore.TSCID')
                        ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                        ->Equal('TEID',$termBefore->TEID)
                        ->OrderBy('SCCode')->Get();
                $nextSchedule = $student->Equal('UName',$user->UName)->Join('TrDetailStudentClass','TrDetailStudentClass.STID','Student.STID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrDetailStudentClass.TSCID')
                        ->Join('TrStudentSchedule','TrDetailStudentClass.TSCID','TrStudentSchedule.TSCID')
                        ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                        ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                        ->Join('SchoolRoomClass','SchoolRoomClass.RCID','TrStudentSchedule.RCID')
                        ->Join('StudyShift','StudyShift.SSID','TrStudentSchedule.SSID')
                        ->NotIn('TrStudentSchedule.TSSID','select TSSID from trdetailstudentschedule')
                        ->Equal('TEID',$termResult->TEID)
                        ->Equal('TSSDate',date('Y-m-d',time()))
                        ->OrderBy('TSSDate','DESC')->Get();
                $scoreGrade = new SchoolGrade();
                $gradeData = $scoreGrade->Equal('CPID',$schoolID)->OrderBy('SGLowerLimit','DESC')->Get();
                $data['schedule'] = $resultStudent;
                $data['score'] = $resultScore;
                $data['gradeScore'] = $gradeData;
                $data['currentTerm'] = $termResult;
                $data['beforeTerm'] = $termBefore;
                $data['nextSchedule'] = $nextSchedule;
                Import::Template('Material');
                Import::View('Material',$data);
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
            if($user->UType == 'Lecture')
                redirect($URI->ReturnURI('App=Class&Com=MaterialLecture'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $data = array();
                $param = $URI->GetURI();
                $term = new Term();
                $task = new Task();
                $termResult = $term->Equal('IsActive','Y')->First();
                $student = new Student();
                $studentID = $student->Equal('UName',$user->UName)->First()->STID;
                $resultStudent = $student->Equal('UName',$user->UName)->Join('TrDetailStudentClass','TrDetailStudentClass.STID','Student.STID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrDetailStudentClass.TSCID')
                        ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                        ->Equal('TEID',$termResult->TEID)
                        ->OrderBy('SCCode')->Get();
                $nextSchedule = $student->Equal('UName',$user->UName)->Join('TrDetailStudentClass','TrDetailStudentClass.STID','Student.STID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrDetailStudentClass.TSCID')
                        ->Join('TrStudentSchedule','TrDetailStudentClass.TSCID','TrStudentSchedule.TSCID')
                        ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                        ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                        ->Join('SchoolRoomClass','SchoolRoomClass.RCID','TrStudentSchedule.RCID')
                        ->Join('StudyShift','StudyShift.SSID','TrStudentSchedule.SSID')
                        ->NotIn('TrStudentSchedule.TSSID','select TSSID from trdetailstudentschedule')
                        ->Equal('TEID',$termResult->TEID)
                        ->Equal('TSSDate',date('Y-m-d',time()))
                        ->OrderBy('TSSDate','DESC')->Get();
                $detailMP = $student->Equal('UName',$user->UName)->Join('TrDetailStudentClass','TrDetailStudentClass.STID','Student.STID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrDetailStudentClass.TSCID')
                        ->Join('TrStudentSchedule','TrDetailStudentClass.TSCID','TrStudentSchedule.TSCID')
                        ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                        ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                        ->Join('SAP','SAP.SAPID','MP.SAPID')
                        ->Equal('TEID',$termResult->TEID)
                        ->Equal('Subject.SUID',$param[3])
                        ->OrderBy('AttnNumber','ASC')->Get();
                $additionalMaterial = $student->Equal('UName',$user->UName)->Join('TrDetailStudentClass','TrDetailStudentClass.STID','Student.STID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrDetailStudentClass.TSCID')
                        ->Join('TrStudentSchedule','TrDetailStudentClass.TSCID','TrStudentSchedule.TSCID')
                        ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                        ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                        ->Join('SAP','SAP.SAPID','MP.SAPID')
                        ->Join('AdditionalMateri','AdditionalMateri.TSCID','TrHeaderStudentClass.TSCID')
                        ->Equal('TEID',$termResult->TEID)
                        ->Equal('Subject.SUID',$param[3])
                        ->OrderBy('AttnNumber','ASC')->Get();
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
                /*echo $firstMP->TSCID;
                echo $task->LastQuery(true);
    */
                $answer = $task->Join('TrHeaderTaskForStudent','TrHeaderTaskForStudent.TID','Task.TID')
                        ->Join('TrDetailTaskForStudent','TrDetailTaskForStudent.THTSID','TrHeaderTaskForStudent.THTSID')
                        ->Equal('STID',$studentID)->Get();

                $data['detailMP']=$detailMP;
                $data['additionalMaterial']=$additionalMaterial;
                $data['resultLO'] = $resultLO;
                $data['nextSchedule'] = $nextSchedule;
                $data['schedule'] = $resultStudent;
                $data['resultBook'] = $resultBook;
                $data['currentTerm'] = $termResult;
                $data['currentMP'] = $param[3];
                $data['detailTask'] = $taskDetail;
                $data['answer'] = $answer;
                Import::Template('Material');
                Import::View('DetailMaterial',$data);
            }
        }
    }

    public function MPDetailLoad(URI $URI, Input $Input)
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

            if($user->UType == 'Lecture')
                redirect($URI->ReturnURI('App=Class&Com=MaterialLecture'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $data = array();
                $param = $URI->GetURI();
                $term = new Term();
                $task = new Task();
                $termResult = $term->Equal('IsActive','Y')->First();
                $student = new Student();
                //$schoolID = $student->Equal('UName',$user->UName)->First()->CPID;
                $detailMP = $student->Equal('UName',$user->UName)->Join('TrDetailStudentClass','TrDetailStudentClass.STID','Student.STID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrDetailStudentClass.TSCID')
                        ->Join('TrStudentSchedule','TrDetailStudentClass.TSCID','TrStudentSchedule.TSCID')
                        ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                        ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                        ->Join('SchoolRoomClass','SchoolRoomClass.RCID','TrStudentSchedule.RCID')
                        ->Join('StudyShift','StudyShift.SSID','TrStudentSchedule.SSID')
                        ->Equal('TEID',$termResult->TEID)
                        ->Equal('MP.MPID',$param[3])
                        ->OrderBy('AttnNumber','ASC')->First();
                $taskDetail = $task->Equal('MPID',$param[3])->OrderBy('TStatus','DESC')->Get();
                $data['detailMP']=$detailMP;
                $data['detailTask'] = $taskDetail;
                Import::Template('Material');
                Import::View('MPDetail',$data);
            }
        }
    }

    public function CompleteScheduleLoad(URI $URI, Input $Input)
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
            if($user->UType == 'Lecture')
                redirect($URI->ReturnURI('App=Class&Com=MaterialLecture'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $term = new Term();
                $termResult = $term->Equal('IsActive','Y')->First();
                $student = new Student();
                $scheduleDetail = $student->Equal('UName',$user->UName)->Join('TrDetailStudentClass','TrDetailStudentClass.STID','Student.STID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrDetailStudentClass.TSCID')
                        ->Join('TrStudentSchedule','TrDetailStudentClass.TSCID','TrStudentSchedule.TSCID')
                        ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                        ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                        ->Join('SchoolRoomClass','SchoolRoomClass.RCID','TrStudentSchedule.RCID')
                        ->Join('StudyShift','StudyShift.SSID','TrStudentSchedule.SSID')
                        ->NotIn('TrStudentSchedule.TSSID','select TSSID from trdetailstudentschedule')
                        ->Equal('TEID',$termResult->TEID)
                        ->OrderBy('TSSDate','DESC')->Get();
                $data['schedule'] = $scheduleDetail;
                Import::Template('Material');
                Import::View('CompleteSchedule',$data);
            }
        }
    }
    
    public function CompleteGradeLoad(URI $URI, Input $Input)
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
            if($user->UType == 'Lecture')
                redirect($URI->ReturnURI('App=Class&Com=MaterialLecture'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $term = new Term();
                $termResult = $term->Equal('IsActive','Y')->First();
                $student = new Student();
                $schoolID = $student->Equal('UName',$user->UName)->First()->CPID;
                $resultScore = $student->Equal('UName',$user->UName)->Join('TrDetailScore','TrDetailScore.STID','Student.STID')
                        ->Join('TrHeaderScore','TrHeaderScore.THSOID','TrDetailScore.THSOID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrHeaderScore.TSCID')
                        ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                        ->Join('Term','Term.TEID','TrHeaderStudentClass.TEID')
                        ->OrderBy('StartPeriode','ASC')
                        ->OrderBy('SCCode')->Get();
                $scoreGrade = new SchoolGrade();
                $gradeData = $scoreGrade->Equal('CPID',$schoolID)->OrderBy('SGLowerLimit','DESC')->Get();
                $data['score'] = $resultScore;
                $data['gradeScore'] = $gradeData;
                Import::Template('Material');
                Import::View('CompleteGrade',$data);
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
            if($user->UType == 'Lecture')
                redirect($URI->ReturnURI('App=Class&Com=MaterialLecture'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $student = new Student();
                $task = new Task();
                $param = $URI->GetURI();
                $TID = $Input->Post('TID');
                $studentData = $student->Equal('UName',$user->UName)->First();
                $fileAnswer = $_FILES['fileAnswer'];
                $taskDetail = $task->Join('MP','MP.MPID','Task.MPID')
                        ->Join('TrHeaderTaskForStudent','TrHeaderTaskForStudent.TID','Task.TID')
                        ->Equal('Task.TID',$TID)->First();
                $sourceFolder = Config::Instance(SETTING_USE)->documentRoot.'/File/Upload/Answer/'.$studentData->STCode.'/';

                if(! file_exists($sourceFolder))
                {
                    mkdir ( $sourceFolder , 0777 , true);
                }
                $fileName = $fileAnswer['name'];
                $fileParse = explode('.',$fileName);
                $fileExt = $fileParse[count($fileParse)-1];
                $fileName = time().'_'.$taskDetail->TID.'_'.$studentData->STCode.'.'.$fileExt;

                $destination = $sourceFolder.$fileName;

                if(move_uploaded_file($fileAnswer['tmp_name'], $destination)) {
                    $trDetailTask = new TrDetailTaskForStudent();

                    $resultTrDetailTask = $trDetailTask->Equal('STID',$studentData->STID)
                            ->Equal('THTSID',$taskDetail->THTSID)->First();

                    if($resultTrDetailTask == null)
                    {
                        $newTrDetailTask = new TrDetailTaskForStudentEntity();
                        $newTrDetailTask->STID = $studentData->STID;
                        $newTrDetailTask->THTSFilePath = $fileName;
                        $newTrDetailTask->THTSUploadTime = date('Y-m-d',time());
                        $newTrDetailTask->THTSUploadCounter = 1;
                        $newTrDetailTask->THTSID = $taskDetail->THTSID;
                        $newTrDetailTask->Checked = 'n';
                        $trDetailTask->Add($newTrDetailTask);
                    }
                    else
                    {
                        $resultTrDetailTask->STID = $studentData->STID;
                        $resultTrDetailTask->THTSFilePath = $fileName;
                        $resultTrDetailTask->THTSUploadTime = date('Y-m-d',time());
                        $resultTrDetailTask->THTSUploadCounter = $resultTrDetailTask->THTSUploadCounter+1;
                        $resultTrDetailTask->THTSID = $taskDetail->THTSID;
                        $resultTrDetailTask->Checked = 'n';
                        $trDetailTask->Update($resultTrDetailTask);
                    }
                }
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            }
        }
    }

    public function UploadTaskPageLoad(URI $URI, Input $Input)
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
            if($user->UType == 'Lecture')
                redirect($URI->ReturnURI('App=Class&Com=MaterialLecture'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $param = $URI->GetURI();
                $term = new Term();
                $data = array();
                //$termResult = $term->Equal('IsActive','Y')->First();
                $student = new Student();
                $task = new Task();
                $studentID = $student->Equal('UName',$user->UName)->First()->STID;
                $listClassID = $student->Join('TrDetailStudentClass','Student.STID','TrDetailStudentClass.STID')
                        ->Equal('Student.STID',$studentID)->Get();

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
                    $data['studentID'] = $studentID;
                    $data['taskID'] = $param[3];
                    Import::Template('Material');
                    Import::View('UploadTask',$data);
                }
                else
                    echo "<script>history.back();</script>";
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
            if($user->UType == 'Lecture')
                redirect($URI->ReturnURI('App=Class&Com=MaterialLecture'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $param = $URI->GetURI();
                $term = new Term();
                $termResult = $term->Equal('IsActive','Y')->First();
                $student = new Student();
                //$schoolID = $student->Equal('UName',$user->UName)->First()->CPID;
                $detailMP = $student->Equal('UName',$user->UName)->Join('TrDetailStudentClass','TrDetailStudentClass.STID','Student.STID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrDetailStudentClass.TSCID')
                        ->Join('TrStudentSchedule','TrDetailStudentClass.TSCID','TrStudentSchedule.TSCID')
                        ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                        ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                        ->Join('SchoolRoomClass','SchoolRoomClass.RCID','TrStudentSchedule.RCID')
                        ->Join('StudyShift','StudyShift.SSID','TrStudentSchedule.SSID')
                        ->Equal('TEID',$termResult->TEID)
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
            if($user->UType == 'Lecture')
                redirect($URI->ReturnURI('App=Class&Com=MaterialLecture'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $param = $URI->GetURI();
                $term = new Term();
                $task = new Task();
                $termResult = $term->Equal('IsActive','Y')->First();
                $student = new Student();
                $listClassID = $student->Equal('UName',$user->UName)
                        ->Join('TrDetailStudentClass','Student.STID','TrDetailStudentClass.STID')
                        ->Get();

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
            if($user->UType == 'Lecture')
                redirect($URI->ReturnURI('App=Class&Com=MaterialLecture'));
            else if($user->UType == 'Guardian')
                redirect($URI->ReturnURI('App=Class&Com=MaterialGuardian'));
            else
            {
                $param = $URI->GetURI();
                $term = new Term();
                $termResult = $term->Equal('IsActive','Y')->First();
                $termBefore = $term->Equal('IsActive','N')->OrderBy('EndPeriode','DESC') ->First();
                $sID = $param[3];

                $student = new Student();
                //$schoolID = $student->Equal('UName',$user->UName)->First()->CPID;
                $addtionalMaterial = $student->Equal('UName',$user->UName)->Join('TrDetailStudentClass','TrDetailStudentClass.STID','Student.STID')
                        ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrDetailStudentClass.TSCID')
                        ->Join('TrStudentSchedule','TrDetailStudentClass.TSCID','TrStudentSchedule.TSCID')
                        ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                        ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                        ->Join('SchoolRoomClass','SchoolRoomClass.RCID','TrStudentSchedule.RCID')
                        ->Join('StudyShift','StudyShift.SSID','TrStudentSchedule.SSID')
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
    
}
