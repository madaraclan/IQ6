<?php

class Guider extends Model {
	
    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'Guider';
        $this->lastTable = 'Guider';
    }
}

?>