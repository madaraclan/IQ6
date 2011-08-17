<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/**
 * InTechPHP Framework
 *
 * Database Framework Singleton Pattern Support Multi Connection
 *
 * @package		InTechPHP
 * @author		Iqbal Maulana
 * @copyright	Copyright (c) 2011, Intelligence Tech, Inc.
 * @license
 * @link		http://intelligencetech.com
 * @since		Version 1.0
 */

// ------------------------------------------------------------------------
Import::Library('Db.DBPDO');
// ------------------------------------------------------------------------

/**
* Database Class
*
* @package		InTechPHP
* @subpackage	DB
* @category		Libraries
* @author		Iqbal Maulana
*/
class Database {
    private static $instance;
    private $resource;
    private $hostname;
    private $username;
    private $password;
    private $database;
    private $driver;
    private $driverOptions;
    private $customConfig;

    /**
	* Instance Database
	*
	* get instance of Database
	*
	* @return   Database
	*/
    public static function Instance() {
        
        if ( !isset(self::$instance) ) {
            $class  = __CLASS__;
            self::$instance = new $class;
            self::$instance->ResetConfig();
        }
        return self::$instance;

    }

    /**
	* Set Custom Config
	*
	* set custom config for other database connection
	*
    * @access   public
	* @param    string
    * @param    string
    * @param    string
    * @param    string
    * @param    string
    * @param    array
	* @return   void
	*/
    public function SetConfig($hostname, $database, $username = 'root', $password = '', $driver = 'MySQL', $driverOptions = array()) {
        $this->ResetConfig();
        $this->hostname         = $hostname;
        $this->username         = $username;
        $this->password         = $password;
        $this->database         = $database;
        $this->driver           = $driver;
        $this->driverOptions    = $driverOptions;
        $this->customConfig     = true;
        $this->ResetDBSource();
    }

    /**
     * Reset Database Resource
     *
     * reset database resource to create new resource
     *
     * @return void
     */
    public function ResetDBSource() {
        unset($this->resource);
    }

    /**
     * Connect Database
     *
     * connect to database and create database resource
     *
     * @throws CustomException
     * @return database resource
     */
    public function Connect() {
        $driver     = ($this->customConfig) ? $this->driver : Config::Instance(SETTING_USE)->driver;
        $hostname   = ($this->customConfig) ? $this->hostname : Config::Instance(SETTING_USE)->hostname;
        $database   = ($this->customConfig) ? $this->database : Config::Instance(SETTING_USE)->database;
        $username   = ($this->customConfig) ? $this->username : Config::Instance(SETTING_USE)->username;
        $password   = ($this->customConfig) ? $this->password : Config::Instance(SETTING_USE)->password;
        $driverOptions = ($this->customConfig) ? $this->driverOptions : Config::Instance(SETTING_USE)->driverOptions;

        try {
           if(file_exists( PATH_LIBRARIES . DS . 'Db' . DS . 'Drivers' . DS . $driver . '.php' )) {
               require_once PATH_LIBRARIES . DS . 'Db' . DS . 'Drivers' . DS . $driver . '.php';
           }
           else
               throw new CustomException();
        }
        catch(CustomException $e) {
            $errorMessage   = 'Database Driver : <b>'.$driver.'</b> Not Found';
            $e->ShowPHPError (E_ERROR, $errorMessage, $e->getFile(),$e->getLine() );
            exit();
        }


        if ( !isset($this->resource)) {
            try {
                if(class_exists($driver)) {
                    $dsn            = strtolower($driver).":host=$hostname;dbname=$database";
                    $this->resource = new $driver($dsn, $username, $password, $driverOptions);
                }
                else
                    throw new CustomException();
            }
            catch(CustomException $e) {
                $errorMessage   = 'Database Class : <b>'.$driver.'</b> Not Found';
                $e->ShowError('Database Error', $errorMessage);
                exit();
            }
        }

        $this->ResetConfig();
        return $this->resource;
    }

    public function ExecuteQuery($sql) {
        $stmt = $this->resource->prepare($sql);
        try
        {
            if ( ! $stmt->execute()) {
                throw new CustomException();
            }
        }
        catch(CustomException $e) {
            $errMessage = $stmt->errorInfo();
            $e->ShowError('Database Error', $errMessage[2]);
        }
        return $stmt;
    }

    public function Fetch(PDOStatement $stmt, $returnType = PDO::FETCH_OBJ) {
        $data = array();
        
        while($row = $stmt->fetch($returnType))
            array_push($data, $row);
        
        return $data;
    }

    /**
     * Reset Config
     *
     * reset config to use new config
     *
     * @return void
     */
    private function ResetConfig() {
        $this->hostname         = 'localhost';
        $this->username         = 'root';
        $this->password         = '';
        $this->database         = '';
        $this->driver           = 'MySQL';
        $this->driverOptions    = array();
        $this->customConfig     = false;
    }
}
?>