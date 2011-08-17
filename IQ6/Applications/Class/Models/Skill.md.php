<?php

class Skill extends Model {
	
    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'Skill';
        $this->lastTable = 'Skill';
    }
}

?>