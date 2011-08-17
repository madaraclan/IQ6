<?php

class Bibliography extends Model {
	
    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'Bibliography';
        $this->lastTable = 'Bibliography';
    }
}

?>