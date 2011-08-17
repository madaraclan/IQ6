<?php

class TrDetailScore extends Model {

    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'TrDetailScore';
        $this->lastTable = 'TrDetailScore';
    }
}

?>