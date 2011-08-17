<?php

Import::Entity('Account.Userphone');

class Userphone extends Model{
	
	public function __construct() {
        parent::__construct();
        $this->tableName = 'userphone';
        $this->lastTable = 'userphone';
        $this->application = 'Account';
    }
    
	function GetDataUserphone($TokenId){
		
		$Phone = Database::Instance()->ExecuteQuery("
    	select * from userphone where _AliasingName = '".$TokenId."'
    	");
    	$Phone = Database::Instance()->Fetch($Phone);
		
    	//$Phone = $this->Equal('_AliasingName', $TokenId)->Get();
    	
    	return $Phone;
    }	
	
}

?>