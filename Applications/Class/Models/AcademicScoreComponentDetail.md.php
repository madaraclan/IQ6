<?php

class AcademicScoreComponentDetail extends Model {
	
    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'AcademicScoreComponentDetail';
        $this->lastTable = 'AcademicScoreComponentDetail';
    }
}

?>