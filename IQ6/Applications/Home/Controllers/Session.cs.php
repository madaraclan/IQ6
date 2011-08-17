<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');

Import::Library('Graphic.AmChartGenerator');
class _Session extends Controller {
    public function __construct() {
        Import::Model("home.user");
        Import::Model("home.userloglogin");
    }

    public function MainLoad(URI $URI, Input $Input) {
		if ($Input->Session()->GetValue('user') != NULL || $Input->Cookie()->GetValue('user') != NULL) {
			redirect($URI->ReturnURI('App=Social&Com=Wall'));
		}

		Import::Template('Login', NULL, 'Guest');
        Import::View('Login',array('error'=>$Input->Session()->GetValue('error')));
        if($Input->Session()->GetValue('error') != NULL)
            $Input->Session()->DeleteValue('error');
    }

    public function LoginLoad(URI $URI, Input $Input) {
        $user = new User();
        $result = $user->Equal('UName',$Input->Post('userID'))->Equal('UPass',$Input->Post('password'))->Equal('IsActive','Y')->Get();
        if(empty($result))
        {
            $Input->Session()->SetValue('error','Kombinasi username dan password salah');
            redirect($URI->ReturnURI('App=Home&Com=Session'));
        }
        else
        {
            $data = $result[0];
            if($Input->Post('alwaysLogedIn'))
            {
                $Input->Cookie()->SetValue('user',$data);
                $Input->Session()->DeleteValue('user');
            }
            else
            {
                $Input->Session()->SetValue('user',$data);
                $Input->Cookie()->DeleteValue('user');
            }
            $userLog = new UserLogLogin();
            $userLog->OrderBy('ULodId','DESC');
            $logId = 0;
            $resultLog = $userLog->Get();
            if(empty($resultLog))
                $logId = 0;
            else
            {
                foreach($resultLog as $log)
                {
                    if($log->ULodId > $logId)
                        $logId = $log->ULodId;
                }
            }
            $userLogEntities = new UserLogLoginEntity();
            $userLogEntities->ULodId = $logId+1;
            $userLogEntities->UName = $Input->Post('userID');
            $userLogEntities->ULogIP = $_SERVER['REMOTE_ADDR'];
            $userLogEntities->ULogTime = date('c',time());
            $userLog->Add($userLogEntities);
			redirect($URI->ReturnURI('App=Social&Com=Wall'));
        }
    }

    public function GetDataLoad(URI $URI, Input $Input)
    {
        var_dump($Input->Session()->GetValue('user'));
    }

    public function ClearDataLoad(URI $URI, Input $Input)
    {
        $Input->Session()->DeleteAllValue();
    }

    public function TestChartLoad(URI $URI, Input $Input)
    {
        $chart = new AmChartGenerator();
        $chart->CreateBarChart(array('data1'=>'USA', 'data2'=>20, 'color'=>'#FFFFFF'),'data1','data2','color','Test Am Chart');
    }
}
