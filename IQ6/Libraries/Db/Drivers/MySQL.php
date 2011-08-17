<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/**
 * InTechPHP Framework
 *
 * Database Driver for MySQL
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
* MySQL Class
*
* @package		InTechPHP
* @subpackage	Drivers
* @category		Libraries
* @author		Iqbal Maulana
*/
class MySQL extends DBPDO {
    public function __construct($dsn, $username = 'root', $password = '', $driverOptions = array()) {
        parent::__construct($dsn, $username, $password, $driverOptions);
    }

    /**
	* Get Select Results MySQL Driver Of Query by DBPDO Parameter
	*
	* get result of query include condition that set before
	*
    * @access   public
	* @param    string
	* @param    array
	* @return   array
	*/
	public function GetResults($table, $fields = array()) {
		$data = array();
		$query = 'SELECT ' . (count($fields) == 0 ? '*' : implode(',', $fields)) . ' FROM ' . $table;

        foreach($this->joinCondition as $joinCondition) {
            $query  .= $joinCondition;
        }

		if($this->queryCondition != '')
			$query .= ' WHERE ' . $this->queryCondition;

		if(count($this->orderFields) != 0)
			$query .= ' ORDER BY ' . implode(',',$this->orderFields);

		if($this->limit['offset'] != -1 && $this->limit['rowCount'] != -1)
			$query .= ' LIMIT ' . $this->limit['offset'] . ', ' . $this->limit['rowCount'];

		$stmt = $this->prepare($query);

        $this->lastQuery = $query;
		foreach($this->parameterCondition as $param) {
			$stmt->bindParam($param['name'], $param['value'], $param['dataType']);
            //$this->lastQuery = str_replace($param['name'], $param['value'], $this->lastQuery);
		}

        //$stmt = $this->prepare($this->lastQuery);

        try {
            
            if ($stmt->execute()) {
                while($row = $stmt->fetch(PDO::FETCH_OBJ))
                    array_push($data, $row);

                $this->lastCondition = $this->queryCondition;
                $this->lastParameterCondition = $this->parameterCondition;
                $this->ResetCondition();

            } else {
                $this->ResetCondition();
                //throw new Exception('Error Query : ' . implode(',', $stmt->errorInfo()));
                throw new CustomException();
            }
        } catch(CustomException $e) {
            $errMessage = $stmt->errorInfo();
            $e->ShowError('Database Error', $errMessage[2]);
        }
		return $data;
	}

    /**
	* Last ID Inserted
	*
	* get last id of added record
	*
	* @access   public
	* @return   int
	*/
    public function GetLastInsertID() {
        return $this->lastInsertID();
    }
}

?>