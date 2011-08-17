<?php

class TrStudentSchedule extends Model {

    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'TrStudentSchedule';
        $this->lastTable = 'TrStudentSchedule';
    }
}

?>