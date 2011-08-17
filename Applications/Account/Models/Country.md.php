<?php
	
Import::Entity('Account.Country');

class Country extends Model{
	
	public function __construct() {
        parent::__construct();
        $this->tableName = 'country';
        $this->lastTable = 'country';
        $this->application = 'Account';
    }
    
	function GetDataCountry($CID){
		
		$Country = Database::Instance()->ExecuteQuery("
    	select * from country where CID = '".$CID."'
    	");
    	$Country = Database::Instance()->Fetch($Country);
		
    	//$Country = $this->Equal('CID', $CID)->Get();
    	
    	return $Country;
    }
	
}

?>