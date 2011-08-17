<?php
/**
 * Created by JetBrains PhpStorm.
 * User: William
 * Date: 7/3/11
 * Time: 5:34 PM
 * To change this template use File | Settings | File Templates.
 */
 
class TrDetailTaskForStudent extends Model {

    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'TrDetailTaskForStudent';
        $this->lastTable = 'TrDetailTaskForStudent';
    }
}