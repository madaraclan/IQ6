<?php

Import::Entity('Account.City');

class City extends Model{
	
	public function __construct() {
        parent::__construct();
        $this->tableName = 'city';
        $this->lastTable = 'city';
        $this->application = 'Account';
    }
    
    function GetDataCity($CTID){
    	$City = $this->Equal('CTID', $CTID)->Get();
    	return $City;
    }
    
    function GetCity(Input $Input){
    	$City = $Input->Post('InputCurrentCity');
    	
    	$qCity = Database::Instance()->ExecuteQuery("
    	select city.*, country.CName, nationality.NName
    	from city, country, nationality
    	where
    	city.CID = country.CID and
    	city.NID = nationality.NID and
    	(
    	city.CTName like '%".$City."%' or
    	country.CName like '%".$City."%' or
    	nationality.NName like '%".$City."%'
    	)
    	");
    	$qCity = Database::Instance()->Fetch($qCity);
    	
    	/*
    	$qCity = $this
    			->Join('country', 'city.CID', 'country.CID')
    			->Join('nationality', 'city.NID', 'nationality.NID')
    			->Like('city.CTName', '%'.$City.'%', PDO::PARAM_STR, 'or')
    			->Like('country.CName', '%'.$City.'%', PDO::PARAM_STR, 'or')
    			->Like('nationality.NName', '%'.$City.'%', PDO::PARAM_STR, 'or')
    			->Get();*/	
    	
    	if ($qCity){
    		$return = '';
    	foreach($qCity as $item){
    		$return .= '<li 
    		data-CTID="'.$item->CTID.'"
    		data-CTName="'.$item->CTName.'" 
    		data-CName="'.$item->CName.'" 
    		data-NName="'.$item->NName.'"
    		data-CID="'.$item->CID.'"
    		data-NID="'.$item->NID.'"
    		><div>'.$item->CTName.', '.$item->CName.'</div><div>'.$item->NName.'</div></li>';
    	}
    		return json_encode(array(
    			'status' => 1,
    			'message' => $return
    		));
    	}else{
    		return json_encode(array(
    			'status' => 0
    		));
    	}
    }
	
}

?>