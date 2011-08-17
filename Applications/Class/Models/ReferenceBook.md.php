<?php

class ReferenceBook extends Model {
	
    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'ReferenceBook';
        $this->lastTable = 'ReferenceBook';
    }
}

?>