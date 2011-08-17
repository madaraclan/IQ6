<?php

Import::Entity('Account.Usermusic');

class Usermusic extends Model{
	
	public function __construct() {
        parent::__construct();
        $this->tableName = 'usermusic';
        $this->lastTable = 'usermusic';
        $this->application = 'Account';
    }
    
	function GetDataMusics($TokenId){
		
		$Musics = Database::Instance()->ExecuteQuery("
    	select * from usermusic where _AliasingName = '".$TokenId."'
    	order by UMID desc
    	");
    	$Musics = Database::Instance()->Fetch($Musics);
		
    	//$Musics = $this->Equal('_AliasingName', $TokenId)->OrderBy('UMID', 'desc')->Get();
    	
    	return $Musics;
    }	
	
}

?>