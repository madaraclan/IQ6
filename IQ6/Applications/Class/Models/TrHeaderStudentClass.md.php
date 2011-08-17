<?php

class TrHeaderStudentClass extends Model {

    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'TrHeaderStudentClass';
        $this->lastTable = 'TrHeaderStudentClass';
    }
}

?>