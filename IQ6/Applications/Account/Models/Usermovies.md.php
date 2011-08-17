<?php

Import::Entity('Account.Usermovies');

class Usermovies extends Model{
	
	public function __construct() {
        parent::__construct();
        $this->tableName = 'usermovies';
        $this->lastTable = 'usermovies';
        $this->application = 'Account';
    }
	
	function GetDataMovies($TokenId){
		
		$Movies = Database::Instance()->ExecuteQuery("
    	select * from usermovies where _AliasingName = '".$TokenId."'
    	order by UMVID desc
    	");
    	$Movies = Database::Instance()->Fetch($Movies);
		
    	//$Movies = $this->Equal('_AliasingName', $TokenId)->OrderBy('UMVID', 'desc')->Get();
    	
    	return $Movies;
    }
    
}

?>