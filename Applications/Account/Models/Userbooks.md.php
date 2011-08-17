<?php

Import::Entity('Account.Userbooks');

class Userbooks extends Model{
	
	public function __construct() {
        parent::__construct();
        $this->tableName = 'userbooks';
        $this->lastTable = 'userbooks';
        $this->application = 'Account';
    }
	
	function GetDataBooks($TokenId){
		
		$Books = Database::Instance()->ExecuteQuery("
    	select * from userbooks where _AliasingName = '".$TokenId."'
    	order by UBID desc
    	");
    	$Books = Database::Instance()->Fetch($Books);
		
    	//$Books = $this->Equal('_AliasingName', $TokenId)->OrderBy('UBID', 'desc')->Get();
    	return $Books;
    }
    
}

?>