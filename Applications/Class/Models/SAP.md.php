<?php

class SAP extends Model {
	
    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'SAP';
        $this->lastTable = 'SAP';
    }
}

?>