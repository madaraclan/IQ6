<?php
/**
 * Created by JetBrains PhpStorm.
 * User: William
 * Date: 7/24/11
 * Time: 8:00 PM
 * To change this template use File | Settings | File Templates.
 */
 
class _MaterialGuardian extends Controller {

    public function __construct()
    {
        Import::Model("class.Student");
        Import::Model("class.Guider");
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
            else if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else
            {
                $term = new Term();
                $termResult = $term->Equal('IsActive','Y')->First();
                $termBefore = $term->Equal('IsActive','N')->OrderBy('EndPeriode','DESC') ->First();
                $guider = new Guider();
                $guiderData = $guider->Equal('UName',$user->UName)->First();
                $studentData = $guider->Equal('Guider.UName',$user->UName)->Join('StudentToGuider','StudentToGuider.GID','Guider.GID')
                        ->Join('Student','Student.STID','StudentToGuider.STID')->Get();
                $data = array('studentData'=>$studentData);
                Import::Template('Material');
                Import::View('GuiderMain',$data);
            }
        }
    }

    public function ViewStudentLoad(URI $URI, Input $Input) {
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
            else if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else
            {
                $stCode = $Input->Post("stCode");
                $guider = new Guider();
                $guiderData = $guider->Equal('UName',$user->UName)->First();
                $studentData = $guider->Equal('Guider.UName',$user->UName)->Join('StudentToGuider','StudentToGuider.GID','Guider.GID')
                        ->Join('Student','Student.STID','StudentToGuider.STID')->Equal('STCode',$stCode)->Get();
                if($studentData != NULL)
                {
                    $term = new Term();
                    $termResult = $term->Equal('IsActive','Y')->First();
                    $termBefore = $term->Equal('IsActive','N')->OrderBy('EndPeriode','DESC') ->First();
                    $student = new Student();
                    $schoolID = $student->Equal('STCode',$stCode)->First()->CPID;
                    $resultStudent = $student->Equal('STCode',$stCode)->Join('TrDetailStudentClass','TrDetailStudentClass.STID','Student.STID')
                            ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrDetailStudentClass.TSCID')
                            ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                            ->Equal('TEID',$termResult->TEID)
                            ->OrderBy('SCCode')->Get();
                    $resultScore = $student->Equal('STCode',$stCode)->Join('TrDetailScore','TrDetailScore.STID','Student.STID')
                            ->Join('TrHeaderScore','TrHeaderScore.THSOID','TrDetailScore.THSOID')
                            ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrHeaderScore.TSCID')
                            ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                            ->Equal('TEID',$termBefore->TEID)
                            ->OrderBy('SCCode')->Get();
                    $nextSchedule = $student->Equal('STCode',$stCode)->Join('TrDetailStudentClass','TrDetailStudentClass.STID','Student.STID')
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
                    $data['studentData'] = $studentData[0];
                    $data['schedule'] = $resultStudent;
                    $data['score'] = $resultScore;
                    $data['gradeScore'] = $gradeData;
                    $data['currentTerm'] = $termResult;
                    $data['beforeTerm'] = $termBefore;
                    $data['nextSchedule'] = $nextSchedule;
                    Import::Template('Material');
                    Import::View('MaterialGuardian',$data);
                }
                else
                    redirect($URI->ReturnURI('App=Home&Com=Session'));
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
            else if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else
            {
                $param = $URI->GetURI();
                $stCode = $param[3];
                $sID = $param[4];
                $guider = new Guider();
                $guiderData = $guider->Equal('UName',$user->UName)->First();
                $studentData = $guider->Equal('Guider.UName',$user->UName)->Join('StudentToGuider','StudentToGuider.GID','Guider.GID')
                        ->Join('Student','Student.STID','StudentToGuider.STID')->Equal('STCode',$stCode)->Get();
                if($studentData != NULL)
                {
                    $data = array();
                    $term = new Term();
                    $task = new Task();
                    $termResult = $term->Equal('IsActive','Y')->First();
                    $student = new Student();
                    $studentID = $student->Equal('STCode',$stCode)->First()->STID;
                    $resultStudent = $student->Equal('STCode',$stCode)->Join('TrDetailStudentClass','TrDetailStudentClass.STID','Student.STID')
                            ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrDetailStudentClass.TSCID')
                            ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                            ->Equal('TEID',$termResult->TEID)
                            ->OrderBy('SCCode')->Get();
                    $nextSchedule = $student->Equal('STCode',$stCode)->Join('TrDetailStudentClass','TrDetailStudentClass.STID','Student.STID')
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
                    $detailMP = $student->Equal('STCode',$stCode)->Join('TrDetailStudentClass','TrDetailStudentClass.STID','Student.STID')
                            ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrDetailStudentClass.TSCID')
                            ->Join('TrStudentSchedule','TrDetailStudentClass.TSCID','TrStudentSchedule.TSCID')
                            ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                            ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                            ->Join('SAP','SAP.SAPID','MP.SAPID')
                            ->Equal('TEID',$termResult->TEID)
                            ->Equal('Subject.SUID',$sID)
                            ->OrderBy('AttnNumber','ASC')->Get();
                    $additionalMaterial = $student->Equal('STCode',$stCode)->Join('TrDetailStudentClass','TrDetailStudentClass.STID','Student.STID')
                            ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrDetailStudentClass.TSCID')
                            ->Join('TrStudentSchedule','TrDetailStudentClass.TSCID','TrStudentSchedule.TSCID')
                            ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                            ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                            ->Join('SAP','SAP.SAPID','MP.SAPID')
                            ->Join('AdditionalMateri','AdditionalMateri.TSCID','TrHeaderStudentClass.TSCID')
                            ->Equal('TEID',$termResult->TEID)
                            ->Equal('Subject.SUID',$sID)
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

                    $data['additionalMaterial']=$additionalMaterial;
                    $data['studentData'] = $studentData[0];
                    $data['detailMP']=$detailMP;
                    $data['resultLO'] = $resultLO;
                    $data['nextSchedule'] = $nextSchedule;
                    $data['schedule'] = $resultStudent;
                    $data['resultBook'] = $resultBook;
                    $data['currentTerm'] = $termResult;
                    $data['currentMP'] = $param[3].'/'.$param[4];
                    $data['detailTask'] = $taskDetail;
                    $data['answer'] = $answer;
                    Import::Template('Material');
                    Import::View('DetailMaterialGuardian',$data);
                }
                else
                    redirect($URI->ReturnURI('App=Home&Com=Session'));
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
            else if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else
            {
                $param = $URI->GetURI();
                $stCode = $param[3];
                $guider = new Guider();
                $guiderData = $guider->Equal('UName',$user->UName)->First();
                $studentData = $guider->Equal('Guider.UName',$user->UName)->Join('StudentToGuider','StudentToGuider.GID','Guider.GID')
                        ->Join('Student','Student.STID','StudentToGuider.STID')->Equal('STCode',$stCode)->Get();
                if($studentData != NULL)
                {
                    $data = array();
                    $term = new Term();
                    $task = new Task();
                    $termResult = $term->Equal('IsActive','Y')->First();
                    $student = new Student();
                    //$schoolID = $student->Equal('UName',$user->UName)->First()->CPID;
                    $detailMP = $student->Equal('STCode',$stCode)->Join('TrDetailStudentClass','TrDetailStudentClass.STID','Student.STID')
                            ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrDetailStudentClass.TSCID')
                            ->Join('TrStudentSchedule','TrDetailStudentClass.TSCID','TrStudentSchedule.TSCID')
                            ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                            ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                            ->Join('SchoolRoomClass','SchoolRoomClass.RCID','TrStudentSchedule.RCID')
                            ->Join('StudyShift','StudyShift.SSID','TrStudentSchedule.SSID')
                            ->Equal('TEID',$termResult->TEID)
                            ->Equal('MP.MPID',$param[4])
                            ->OrderBy('AttnNumber','ASC')->First();
                    $taskDetail = $task->Equal('MPID',$param[4])->OrderBy('TStatus','DESC')->Get();
                    $data['studentData'] = $studentData[0];
                    $data['detailMP']=$detailMP;
                    $data['detailTask'] = $taskDetail;
                    Import::Template('Material');
                    Import::View('MPDetailGuardian',$data);
                }
                else
                    redirect($URI->ReturnURI('App=Home&Com=Session'));
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
            else if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else
            {
                $param = $URI->GetURI();
                $stCode = $param[3];
                $guider = new Guider();
                $guiderData = $guider->Equal('UName',$user->UName)->First();
                $studentData = $guider->Equal('Guider.UName',$user->UName)->Join('StudentToGuider','StudentToGuider.GID','Guider.GID')
                        ->Join('Student','Student.STID','StudentToGuider.STID')->Equal('STCode',$stCode)->Get();
                if($studentData != NULL)
                {
                    $term = new Term();
                    $termResult = $term->Equal('IsActive','Y')->First();
                    $student = new Student();
                    $scheduleDetail = $student->Equal('STCode',$stCode)->Join('TrDetailStudentClass','TrDetailStudentClass.STID','Student.STID')
                            ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrDetailStudentClass.TSCID')
                            ->Join('TrStudentSchedule','TrDetailStudentClass.TSCID','TrStudentSchedule.TSCID')
                            ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                            ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                            ->Join('SchoolRoomClass','SchoolRoomClass.RCID','TrStudentSchedule.RCID')
                            ->Join('StudyShift','StudyShift.SSID','TrStudentSchedule.SSID')
                            ->NotIn('TrStudentSchedule.TSSID','select TSSID from trdetailstudentschedule')
                            ->Equal('TEID',$termResult->TEID)
                            ->OrderBy('TSSDate','DESC')->Get();
                    $data['studentData'] = $studentData[0];
                    $data['schedule'] = $scheduleDetail;
                    Import::Template('Material');
                    Import::View('CompleteScheduleGuardian',$data);
                }
                else
                    redirect($URI->ReturnURI('App=Home&Com=Session'));
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
            else if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else
            {
                $param = $URI->GetURI();
                $stCode = $param[3];
                $guider = new Guider();
                $guiderData = $guider->Equal('UName',$user->UName)->First();
                $studentData = $guider->Equal('Guider.UName',$user->UName)->Join('StudentToGuider','StudentToGuider.GID','Guider.GID')
                        ->Join('Student','Student.STID','StudentToGuider.STID')->Equal('STCode',$stCode)->Get();
                if($studentData != NULL)
                {
                    $term = new Term();
                    $termResult = $term->Equal('IsActive','Y')->First();
                    $student = new Student();
                    $schoolID = $student->Equal('STCode',$stCode)->First()->CPID;
                    $resultScore = $student->Equal('STCode',$stCode)->Join('TrDetailScore','TrDetailScore.STID','Student.STID')
                            ->Join('TrHeaderScore','TrHeaderScore.THSOID','TrDetailScore.THSOID')
                            ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrHeaderScore.TSCID')
                            ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                            ->Join('Term','Term.TEID','TrHeaderStudentClass.TEID')
                            ->OrderBy('StartPeriode','ASC')
                            ->OrderBy('SCCode')->Get();
                    $data['studentData'] = $studentData[0];
                    $scoreGrade = new SchoolGrade();
                    $gradeData = $scoreGrade->Equal('CPID',$schoolID)->OrderBy('SGLowerLimit','DESC')->Get();
                    $data['score'] = $resultScore;
                    $data['gradeScore'] = $gradeData;
                    Import::Template('Material');
                    Import::View('CompleteGradeGuardian',$data);
                }
                else
                    redirect($URI->ReturnURI('App=Home&Com=Session'));
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
            else if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else
            {
                $param = $URI->GetURI();
                $stCode = $param[3];
                $guider = new Guider();
                $guiderData = $guider->Equal('UName',$user->UName)->First();
                $studentData = $guider->Equal('Guider.UName',$user->UName)->Join('StudentToGuider','StudentToGuider.GID','Guider.GID')
                        ->Join('Student','Student.STID','StudentToGuider.STID')->Equal('STCode',$stCode)->Get();
                if($studentData != NULL)
                {
                    $term = new Term();
                    $termResult = $term->Equal('IsActive','Y')->First();
                    $student = new Student();
                    //$schoolID = $student->Equal('UName',$user->UName)->First()->CPID;
                    $detailMP = $student->Equal('STCode',$stCode)->Join('TrDetailStudentClass','TrDetailStudentClass.STID','Student.STID')
                            ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrDetailStudentClass.TSCID')
                            ->Join('TrStudentSchedule','TrDetailStudentClass.TSCID','TrStudentSchedule.TSCID')
                            ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                            ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                            ->Join('SchoolRoomClass','SchoolRoomClass.RCID','TrStudentSchedule.RCID')
                            ->Join('StudyShift','StudyShift.SSID','TrStudentSchedule.SSID')
                            ->Equal('TEID',$termResult->TEID)
                            ->Equal('MP.MPID',$param[4])
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
                else
                    redirect($URI->ReturnURI('App=Home&Com=Session'));
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
            else if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else
            {
                $param = $URI->GetURI();
                $stCode = $param[3];
                $guider = new Guider();
                $guiderData = $guider->Equal('UName',$user->UName)->First();
                $studentData = $guider->Equal('Guider.UName',$user->UName)->Join('StudentToGuider','StudentToGuider.GID','Guider.GID')
                        ->Join('Student','Student.STID','StudentToGuider.STID')->Equal('STCode',$stCode)->Get();
                if($studentData != NULL)
                {
                    $term = new Term();
                    $task = new Task();
                    $termResult = $term->Equal('IsActive','Y')->First();
                    $student = new Student();
                    $studentID = $student->Equal('STCode',$stCode)->First()->STID;
                    $listClassID = $student->Join('TrDetailStudentClass','Student.STID','TrDetailStudentClass.STID')
                            ->Equal('Student.STID',$studentID)->Get();

                    $arrayTSCID = array();
                    foreach($listClassID as $classItem){
                        array_push($arrayTSCID,$classItem->TSCID);
                    };

                    $taskDetail = $task->Join('MP','MP.MPID','Task.MPID')
                            ->Join('TrHeaderTaskForStudent','TrHeaderTaskForStudent.TID','Task.TID')
                            ->In('TSCID',$arrayTSCID)
                            ->Equal('Task.TID',$param[4])->First();

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
                else
                    redirect($URI->ReturnURI('App=Home&Com=Session'));
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
            else if($user->UType == 'Student')
                redirect($URI->ReturnURI('App=Class&Com=Material'));
            else
            {
                $param = $URI->GetURI();
                $stCode = $param[3];
                $guider = new Guider();
                $guiderData = $guider->Equal('UName',$user->UName)->First();
                $studentData = $guider->Equal('Guider.UName',$user->UName)->Join('StudentToGuider','StudentToGuider.GID','Guider.GID')
                        ->Join('Student','Student.STID','StudentToGuider.STID')->Equal('STCode',$stCode)->Get();
                if($studentData != NULL)
                {
                    $term = new Term();
                    $termResult = $term->Equal('IsActive','Y')->First();
                    $student = new Student();
                    //$schoolID = $student->Equal('UName',$user->UName)->First()->CPID;
                    $addtionalMaterial = $student->Equal('STCode',$stCode)->Join('TrDetailStudentClass','TrDetailStudentClass.STID','Student.STID')
                            ->Join('TrHeaderStudentClass','TrHeaderStudentClass.TSCID','TrDetailStudentClass.TSCID')
                            ->Join('TrStudentSchedule','TrDetailStudentClass.TSCID','TrStudentSchedule.TSCID')
                            ->Join('Subject','TrHeaderStudentClass.SUID','Subject.SUID')
                            ->Join('MP','MP.MPID','TrStudentSchedule.MPID')
                            ->Join('SchoolRoomClass','SchoolRoomClass.RCID','TrStudentSchedule.RCID')
                            ->Join('StudyShift','StudyShift.SSID','TrStudentSchedule.SSID')
                            ->Join('AdditionalMateri','AdditionalMateri.TSCID','TrHeaderStudentClass.TSCID')
                            ->Equal('TEID',$termResult->TEID)
                            ->Equal('AdditionalMateri.AMID',$param[4])
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
                else
                    redirect($URI->ReturnURI('App=Home&Com=Session'));
            }
        }
    }
}
