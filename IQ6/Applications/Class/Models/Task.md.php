<?php

class Task extends Model {
	
    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'Task';
        $this->lastTable = 'Task';
    }
}

?>