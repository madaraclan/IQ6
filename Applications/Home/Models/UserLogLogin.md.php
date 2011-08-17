<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Import Entities
|--------------------------------------------------------------------------
*/
Import::Entity('home.UserLogLogin');
 
class UserLogLogin extends Model {

    public function __construct() {
        parent::__construct();
        $this->application = 'home';
        $this->tableName = 'UserLogLogin';
        $this->lastTable = 'UserLogLogin';
    }
}
