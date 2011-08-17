<?php

Import::Entity('Account.Userstatuslikes');

class Userstatuslikes extends Model{
	
	public function __construct() {
        parent::__construct();
        $this->tableName = 'userstatuslikes';
        $this->lastTable = 'userstatuslikes';
        $this->application = 'Account';
    }	
    
    public $YouLike = false;
    
    function GetLikeStatus($IdStatus, Input $Input){
    	$q = $this->Equal('USID', $IdStatus)->Get();
    	$Num = count($q);
    	$users = '';$you = '';$count_ex = '';$add = '';
    	if ($Num){
    	$users = array();
    	$i = 0;
    	foreach($q as $user){
    		$UName = $user->UName;
    		if ($UName == $Input->Session('EDU')->GetValue('EDU_TOKENUNAME')){
    			$you = 'You';
    			$this->YouLike = true;
    		}else{
    			if ($i < 2){
    			$users[] = $user->UName;
    			}
    			$i++;
    		}
    		
    	}
    	
    	if ($Num > 1 && $Num < 3 && $you) $you = $you . ' and ';
    	else if ($Num >= 3 && $you) $you = $you . ', ';
    	
    	$users = join(', ', $users);
    	
    	if ($Num == 2 || $i == 2) 
    	$users = str_replace(', ', ' and ', $users);

    	if ($i >= 2){
    		if (!$you){
    			$jml = $Num-2;
    			if ($jml)
    			$add = ' and '.$jml.' people';
    		}else{
    			$jml = $i - 2;
    			if ($jml)
    			$add = ' and '.$jml.' people';
    		}
    	}
    	
    	}
    	return $you.$users.$add;
    }
    
    function LikeStatus(Input $Input){
    	$IdStatus = $Input->Post('IdStatus');
    	$UName = $Input->Session('EDU')->GetValue('EDU_TOKENUNAME');
    	$CekUName = $this
    				->Equal('USID', $IdStatus)
    				->Equal('UName', $UName)
    				->First();
    	$NumUName = count($CekUName);
    	
    	if ($NumUName){
			$this->Delete($CekUName);
    	}else{
    		$DataUserUpdate = new UserstatuslikesEntity();
			$DataUserUpdate->USID = $IdStatus;
			$DataUserUpdate->UName = $UName;
			$this->Add($DataUserUpdate);
    	}
    	
    	$res = $this->GetLikeStatus($IdStatus, $Input);
    	
    	return json_encode(array('status' => 1, 'html' => $res));
    	
    }
	
}

?>