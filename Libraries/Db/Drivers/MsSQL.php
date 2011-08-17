<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/**
 * InTechPHP Framework
 *
 * Database Driver for MsSQL
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
* MsSQL Class
*
* @package		InTechPHP
* @subpackage	Drivers
* @category		Libraries
* @author		Iqbal Maulana
*/
class MsSQL extends DBPDO {
    public function __construct($dsn, $username = 'root', $password = '', $driverOptions = array()) {
        parent::__construct($dsn, $username, $password, $driverOptions);
    }
    /**
	* Get Select Results MsSQL Driver Of Query by DBPDO Parameter
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

        if(count($this->orderFields) != 0)
			$orderCondition = implode(',',$this->orderFields);
        else
            $orderCondition = '(
                SELECT column_name FROM information_schema.columns
                WHERE table_name = \'' . $table . '\'
		        AND ordinal_position <= 1
            )';

        $query  = 'SELECT * FROM (';

		$query .= 'SELECT ' . (count($fields) == 0 || $fields == '*' ? '*' : implode(',', $fields)) .', ';
        $query .= 'ROW_NUMBER() OVER(
            ORDER BY ' . $orderCondition . '
        ) AS rowNum';
        $query .= ' FROM ' . $table;

        foreach($this->joinCondition as $joinCondition) {
            $query  .= $joinCondition;
        }

		if($this->queryCondition != '')
			$query .= ' WHERE ' . $this->queryCondition;

        $query .= ' ) AS TempTable ';

        if($this->limit['offset'] != -1 && $this->limit['rowCount'] != -1) {
            $offset = $this->limit['offset'] + 1;

            $query .= 'WHERE rowNum BETWEEN ' . ($offset) . ' AND
                      ' . ( $this->limit['rowCount'] + ($offset - 1) );

        }
        
		$stmt = $this->prepare($query);
        
        $this->lastQuery = $query;
		foreach($this->parameterCondition as $param) {
			$stmt->bindParam($param['name'], $param['value'], $param['dataType']);
            $this->lastQuery = str_replace($param['name'], $param['value'], $this->lastQuery);
		}

        try {
            if($stmt->execute()) {
                while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                    unset($row->rowNum);
                    array_push($data, $row);
                }

                $this->lastCondition = $this->queryCondition;
                $this->lastParameterCondition = $this->parameterCondition;
                $this->ResetCondition();

            } else {
                $this->ResetCondition();
                throw new CustomException();
            }
        } catch(CustomException $e) {
            $errMessage = $stmt->errorInfo();
            $e->ShowError('Database Error', $errMessage[2]);
            exit();
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
        $query  = 'SELECT @@IDENTITY AS lastID';
        $stmt   = $this->prepare($query);

        try {
            if($stmt->execute()) {
                $row    = $stmt->fetch(PDO::FETCH_OBJ);
                return (int)$row->lastID;
            }
            else
                throw new CustomException();
        }
        catch(CustomException $e) {
            $errMessage = $stmt->errorInfo();
            $e->ShowError('Database Error', $errMessage[2]);
            exit();
        }
    }
}

?>