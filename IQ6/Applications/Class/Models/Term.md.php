<?php

class Term extends Model {

    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'Term';
        $this->lastTable = 'Term';
    }
}

?>