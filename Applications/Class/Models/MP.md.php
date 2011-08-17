<?php

class MP extends Model {
	
    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'MP';
        $this->lastTable = 'MP';
    }
}

?>