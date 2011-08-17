<?php

class TrDetailStudentClass extends Model {

    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'TrDetailStudentClass';
        $this->lastTable = 'TrDetailStudentClass';
    }
}

?>