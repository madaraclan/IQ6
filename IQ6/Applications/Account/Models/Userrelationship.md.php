<?php

Import::Entity('Account.Userrelationship');

class Userrelationship extends Model{
	
	public function __construct() {
        parent::__construct();
        $this->tableName = 'userrelationship';
        $this->lastTable = 'userrelationship';
        $this->application = 'Account';
    }	
    
    function CekRelation($TokenId){
    	
    	/*
    	$q = Database::Instance()->ExecuteQuery("
    	select * from userrelationship
    	where
    	URUName = '".$TokenId."' or
    	URToUName = '".$TokenId."'
    	");
    	$q = Database::Instance()->Fetch($q);
    	*/
    	
    	$q = $this
    				->Equal('URUName', $TokenId, PDO::PARAM_STR, 'or')
    				->Equal('URToUName', $TokenId, PDO::PARAM_STR, 'or')
    				->First();
    	
    	return count($q);
    }
    
	function GetDataRelation($TokenId){
		
		/*
		$Relation = Database::Instance()->ExecuteQuery("
    	select userrelationship.*, user.* from userrelationship, user, relationship
    	where
    	userrelationship.URToUName = userrelationship.URToUName and
    	relationship.RID = userrelationship.RID and
    	URUName = '".$TokenId."'
    	");
    	$Relation = Database::Instance()->Fetch($Relation);
		*/
		
    	$Relation = $this
    				->LeftJoin('user', 'user.UName', 'userrelationship.URToUName')
    				->LeftJoin('relationship', 'relationship.RID', 'userrelationship.RID')
    				->Equal('URUName', $TokenId)->Get();
    	
    	return $Relation;
    }
	
}

?>