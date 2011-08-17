<?php

class SubjectCategory extends Model {
	
    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'SubjectCategory';
        $this->lastTable = 'SubjectCategory';
    }
}

?>