<?php

class Subject extends Model {
	
    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'Subject';
        $this->lastTable = 'Subject';
    }
}

?>