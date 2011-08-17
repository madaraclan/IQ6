<?php

Import::Entity('Account.Userhobby');

class Userhobby extends Model{
	
	public function __construct() {
        parent::__construct();
        $this->tableName = 'userhobby';
        $this->lastTable = 'userhobby';
        $this->application = 'Account';
    }
	
	function GetDataHobby($TokenId){
		
		$Hobby = Database::Instance()->ExecuteQuery("
    	select * from userhobby where _AliasingName = '".$TokenId."'
    	order by UHID desc
    	");
    	$Hobby = Database::Instance()->Fetch($Hobby);
		
    	//$Hobby = $this->Equal('_AliasingName', $TokenId)->OrderBy('UHID', 'desc')->Get();
    	
    	return $Hobby;
    }
    
}

?>