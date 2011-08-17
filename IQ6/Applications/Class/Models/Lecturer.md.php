<?php

class Lecturer extends Model {
	
    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'Lecturer';
        $this->lastTable = 'Lecturer';
    }
}

?>