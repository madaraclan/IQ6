<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Iqbal Maulana
 * Date: 5/31/11
 * Time: 6:56 PM
 * To change this template use File | Settings | File Templates.
 */

Import::Entity('Test.City');

class City extends Model {

    public function __construct() {
        parent::__construct();
        $this->tableName = 'city';
        $this->lastTable = 'city';
        $this->application = 'Test';
    }
}
