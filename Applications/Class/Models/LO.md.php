<?php
/**
 * Created by JetBrains PhpStorm.
 * User: William
 * Date: 7/3/11
 * Time: 9:13 AM
 * To change this template use File | Settings | File Templates.
 */
 
class LO extends Model {

    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'LO';
        $this->lastTable = 'LO';
    }
}
