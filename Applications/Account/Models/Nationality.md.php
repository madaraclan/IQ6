<?php
	
Import::Entity('Account.Nationality');

class Nationality extends Model{
	
	public function __construct() {
        parent::__construct();
        $this->tableName = 'nationality';
        $this->lastTable = 'nationality';
        $this->application = 'Account';
    }
    
	function GetDataNational($NID){
		
		$Nationality = Database::Instance()->ExecuteQuery("
    	select * from nationality where NID = '".$NID."'
    	");
    	$Nationality = Database::Instance()->Fetch($Nationality);
		
    	//$Nationality = $this->Equal('NID', $NID)->Get();
    	
    	return $Nationality;
    }
	
}

?>