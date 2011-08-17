<?php

class TaskAnswer extends Model {
	
    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'TaskAnswer';
        $this->lastTable = 'TaskAnswer';
    }
}

?>