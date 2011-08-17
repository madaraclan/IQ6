<?php

class Schedule extends Model {
	
    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'Schedule';
        $this->lastTable = 'Schedule';
    }
}

?>