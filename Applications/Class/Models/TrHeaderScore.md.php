<?php

class TrHeaderScore extends Model {

    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'TrHeaderScore';
        $this->lastTable = 'TrHeaderScore';
    }
}

?>