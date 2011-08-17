<?php

class MainContent extends Model {
	
    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'MainContent';
        $this->lastTable = 'MainContent';
    }
}

?>