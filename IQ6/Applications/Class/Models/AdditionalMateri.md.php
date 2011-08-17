<?php
/**
 * Created by JetBrains PhpStorm.
 * User: William
 * Date: 7/27/11
 * Time: 9:17 PM
 * To change this template use File | Settings | File Templates.
 */
 
class AdditionalMateri extends Model {

    public function __construct() {
        parent::__construct();
        $this->application = 'Class';
        $this->tableName = 'AdditionalMateri';
        $this->lastTable = 'AdditionalMateri';
    }
}