<?php

class TrHeaderTaskForStudent extends Model {

    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'TrHeaderTaskForStudent';
        $this->lastTable = 'TrHeaderTaskForStudent';
    }
}

?>