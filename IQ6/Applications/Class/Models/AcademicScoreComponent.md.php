<?php

class AcademicScoreComponent extends Model {
	
    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'AcademicScoreComponent';
        $this->lastTable = 'AcademicScoreComponent';
    }
}

?>