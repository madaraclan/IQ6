<?php

class SchoolGrade extends Model {

    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'SchoolGrade';
        $this->lastTable = 'SchoolGrade';
    }
}

?>