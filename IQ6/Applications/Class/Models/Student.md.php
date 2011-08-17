<?php

class Student extends Model {
	
    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'Student';
        $this->lastTable = 'Student';
    }
}

?>