<?php

class SupportContent extends Model {
	
    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'SupportContent';
        $this->lastTable = 'SupportContent';
    }
}

?>