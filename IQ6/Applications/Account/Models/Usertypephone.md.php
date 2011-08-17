<?php

Import::Entity('Account.Usertypephone');

class Usertypephone extends Model{
	
	public function __construct() {
        parent::__construct();
        $this->tableName = 'usertypephone';
        $this->lastTable = 'usertypephone';
        $this->application = 'Account';
    }
    
	function GetDataUsertypephone($TokenId){
    	$TypePhone = $this->Get();
    	return $TypePhone;
    }	
	
}

?>