<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/**
 * InTechPHP Framework
 *
 * Model Framework for MVC - Model
 *
 * @package		InTechPHP
 * @author		Iqbal Maulana
 * @copyright	Copyright (c) 2011, Intelligence Tech, Inc.
 * @license
 * @link		http://intelligencetech.com
 * @since		Version 1.0
 */

// ------------------------------------------------------------------------

/**
* Model Class
*
* @package		InTechPHP
* @subpackage	Core
* @category		Libraries
* @author		Iqbal Maulana
*/
abstract class Model {
    private $db;
    protected $tableName;
    protected $lastTable;
    protected $application;

    /**
	 * Constructor
	 *
	 * create database instance when create model
	 *
     * @access  public
     * @return  void
	 */
    public function __construct($hostname = "", $database = "", $username = "root", $password = "", $driver = "MySQL", $driverOptions = array()) {
        if ( ! empty($hostname)) {
            Database::Instance()->SetConfig($hostname, $database, $username, $password, $driver, $driverOptions);
        }

        $this->db   = Database::Instance()->Connect();
    }

    /**
     * Database Instance
     *
     * get database instance
     *
     * @access  protected
     * @return  database
     */
    protected function DBInstance() {
        return $this->db;
    }


    public function LastQuery($die = TRUE) {
        $this->DBInstance()->LastQuery($die);
    }

    public function Limit($rowCount, $offset = 0) {
        $this->DBInstance()->Limit($rowCount, $offset);
        return $this;
    }

    public function Like($field, $value, $dataType = PDO::PARAM_STR, $conLogic = 'AND') {
        $this->DBInstance()->Like($field, $value, $dataType, $conLogic);
        return $this;
    }

    public function NotLike($field, $value, $dataType = PDO::PARAM_STR, $conLogic = 'AND') {
        $this->DBInstance()->NotLike($field, $value, $dataType, $conLogic);
        return $this;
    }

    public function In($field, $value, $conLogic = 'AND') {
        $this->DBInstance()->In($field, $value, $conLogic);
        return $this;
    }

    public function NotIn($field, $value, $conLogic = 'AND') {
        $this->DBInstance()->NotIn($field, $value, $conLogic);
        return $this;
    }

    public function Equal($field, $value, $dataType = PDO::PARAM_STR, $conLogic = 'AND') {
        $this->DBInstance()->Equal($field, $value, $dataType, $conLogic);
        return $this;
    }

    public function NotEqual($field, $value, $dataType = PDO::PARAM_STR, $conLogic = 'AND') {
        $this->DBInstance()->NotEqual($field, $value, $dataType, $conLogic);
        return $this;
    }

    public function LessThan($field, $value, $data_type = PDO::PARAM_STR, $con_logic = 'AND') {
        $this->DBInstance()->LessThan($field, $value, $data_type, $con_logic);
        return $this;
    }

    public function LessEqualThan($field, $value, $data_type = PDO::PARAM_STR, $con_logic = 'AND') {
        $this->DBInstance()->LessEqualThan($field, $value, $data_type, $con_logic);
        return $this;
    }

    public function MoreThan($field, $value, $data_type = PDO::PARAM_STR, $con_logic = 'AND') {
        $this->DBInstance()->MoreThan($field, $value, $data_type, $con_logic);
        return $this;
    }

    public function MoreEqualThan($field, $value, $data_type = PDO::PARAM_STR, $con_logic = 'AND') {
        $this->DBInstance()->MoreEqualThan($field, $value, $data_type, $con_logic);
        return $this;
    }

    public function OrderBy($fieldName , $order = "ASC") {
        $this->DBInstance()->OrderBy($fieldName , $order);
        return $this;
    }

    public function Join($tableName, $key1 = "", $key2 = "") {
        return $this->_Join($tableName, $key1, $key2, 'INNER JOIN');
    }

    public function LeftJoin($tableName, $key1 = "", $key2 = "") {
        return $this->_Join($tableName, $key1, $key2, 'LEFT JOIN');
    }

    public function RightJoin($tableName, $key1 = "", $key2 = "") {
        return $this->_Join($tableName, $key1, $key2, 'RIGHT JOIN');
    }

    private function _Join($tableName, $key1, $key2, $joinType) {
        if (! $key1 || ! $key2) {
            Import::Entity($this->application.'.'.$tableName);
            $classJoin      = $tableName."Entity";
            $classOrigin    = $this->tableName."Entity";

            $objJoin    = new $classJoin();
            $objOrigin  = new $classOrigin();

            $keyJoin = "";
            foreach($objOrigin as $var=>$val) {
                foreach($objJoin as $varJoin=>$valJoin) {
                    if($var == $varJoin) {
                        $keyJoin = $var;
                        break;
                    }
                }
                if($keyJoin) break;
            }
            $key1 = $this->lastTable.".".$keyJoin;
            $key2 = $tableName.".".$keyJoin;
        }
        else {
            $parts = explode(".", $key1);
            if($parts[0] != $this->lastTable) $this->lastTable = $parts[0];
        }
        $this->DBInstance()->Join($tableName, $key1, $key2, $joinType);
        return $this;
    }

    public function Get() {
        $results   = $this->DBInstance()->GetResults($this->tableName);
        return $results;
    }

    public function First() {
        $result = $this->Limit(1)
                       ->DBInstance()
                       ->GetResults($this->tableName);

        if (is_array($result) && ! empty($result[0])) return $result[0];
        return NULL;
    }

    public function Add($userLogLogin) {
        if (is_array($userLogLogin) && count($userLogLogin) > 0) {
            foreach ($userLogLogin as $object) {
                $this->Add($object);
            }
        }
        elseif (is_object($userLogLogin)) {
            $objects = $userLogLogin;
            foreach($objects as $attribute=>$value) {
                $this->DBInstance()->BindInsertParam($attribute, $value);
            }
            $this->DBInstance()->Insert($this->tableName);
        }
    }

    public function Update($userLogLogin) {
        if (is_array($userLogLogin) && count($userLogLogin) > 0) {
            foreach ($userLogLogin as $object) {
                $this->Update($object);
            }
        }
        elseif (is_object($userLogLogin)) {
            $objects = $userLogLogin;

            foreach($objects as $attribute=>$value) {
                $this->DBInstance()->BindUpdateParam($attribute, $value);
            }
            $this->DBInstance()->UpdateWithLastCondition($this->tableName);
        }
    }

    public function Delete($userLogLogin) {
        if (is_array($userLogLogin) && count($userLogLogin) > 0) {
            foreach ($userLogLogin as $object) {
                $this->Delete($object);
            }
        }
        elseif (is_object($userLogLogin)) {
            $objects = $userLogLogin;

            foreach($objects as $attribute=>$value) {
                $this->DBInstance()->Equal($attribute, $value);
            }
            $this->DBInstance()->Delete($this->tableName);
        }
    }
}
?>