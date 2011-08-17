<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Import Entities
|--------------------------------------------------------------------------
*/
Import::Entity('home.User');
 
class User extends Model {

    public function __construct() {
        parent::__construct();
        $this->application = 'home';
        $this->tableName = 'User';
        $this->lastTable = 'User';
    }
}
