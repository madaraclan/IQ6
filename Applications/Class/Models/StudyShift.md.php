<?php

class StudyShift extends Model {

    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'StudyShift';
        $this->lastTable = 'StudyShift';
    }
}

?>