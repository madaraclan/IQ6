<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/**
 * InTechPHP Framework
 *
 * Database PDO Framework for multi connection
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
* DBPDO Class
*
* @package		InTechPHP
* @subpackage	DB
* @category		Libraries
* @author		Iqbal Maulana
*/

class DBPDO extends PDO {
    protected $queryCondition;
    protected $joinCondition;
    protected $parameterCondition;
    protected $orderFields;
    protected $limit;
    protected $updateCondition;
    protected $insertFields;
    protected $lastInsertID;
    protected $lastCondition;
    protected $lastParameterCondition;
    protected $lastQuery;

    /**
	* DBPDO Constructor
	*
	* constructor of DBPDO class, inheritance from PDO class
	*
    * @access   public
	* @param    string
	* @param    string
	* @param    string
	* @param    string
	* @return   DBPDO object
	*/
    public function __construct($dsn, $username, $password, $driverOptions = array()) {
        parent::__construct($dsn, $username, $password, $driverOptions);
        $this->ResetCondition();
    }

    /**
	 * Display Limit for DBPDO Parameter
	 *
	 * set display limit for query
	 *
     * @access  public
	 * @param   int
	 * @param   int
	 * @return  DBPDO object
	 */
    public function Limit($rowCount, $offset=0) {
        $this->limit['offset']      = $offset;
        $this->limit['rowCount']    = $rowCount;
        return $this;
    }

    /**
	* Like Condition for DBPDO Parameter
	*
	* set condition for like
	*
    * @access   public
	* @param    string
	* @param    mixed
	* @param    PDO_PARAM
	* @param    string
	* @return   DBPDO object
	*/
    public function Like($field, $value, $dataType = PDO::PARAM_STR, $conLogic = 'AND') {
        $this->SetCondition($field, $value, 'LIKE', $dataType, $conLogic);
        return $this;
    }

    /**
	* Not Like Condition for DBPDO Parameter
	*
	* set condition for not like
	*
	* @access   public
    * @param    string
	* @param    mixed
	* @param    PDO_PARAM
	* @param    string
	* @return   DBPDO object
	*/
    public function NotLike($field, $value, $dataType = PDO::PARAM_STR, $conLogic = 'AND') {
        $this->SetCondition($field, $value, 'NOT LIKE', $dataType, $conLogic);
        return $this;
    }

    /**
     * In Condition for DBPDO Parameter
     *
     * set condition for in
     *
     * @param  string
     * @param  string|array
     * @param PDO_PARAM
     * @param string
     * @return DBPDO object
     */
    public function In($field, $value, $conLogic = 'AND') {
        $value = (is_array($value)) ? implode(',', $value) : $value;
        if($this->queryCondition != '')
            $this->queryCondition .= " $conLogic ";

        $this->queryCondition   .= " $field IN ( $value )";
        return $this;
    }

    /**
     * NotIn Condition for DBPDO Parameter
     *
     * set condition for not in
     *
     * @param  string
     * @param  string|array
     * @param PDO_PARAM
     * @param string
     * @return DBPDO object
     */
    public function NotIn($field, $value, $conLogic = 'AND') {
        $value = (is_array($value)) ? implode(',', $value) : $value;
        if($this->queryCondition != '')
            $this->queryCondition .= " $conLogic ";

        $this->queryCondition   .= " $field NOT IN ( $value )";
        return $this;
    }

    /**
	* Equal Condition for DBPDO Parameter
	*
	* set condition for equal '='
	*
    * @access   public
	* @param    string
	* @param    mixed
	* @param    PDO_PARAM
	* @param    string
	* @return   DBPDO object
	*/
    public function Equal($field, $value, $dataType = PDO::PARAM_STR, $conLogic = 'AND') {
        $this->SetCondition($field, $value, '=', $dataType, $conLogic);
        return $this;
    }

    /**
	* Not Equal Condition for DBO Parameter
	*
	* set condition for not equal '!='
	*
	* @access   public
    * @param    string
	* @param    mixed
	* @param    PDO_PARAM
	* @param    string
	* @return   DBPDO object
	*/
    public function NotEqual($field, $value, $dataType = PDO::PARAM_STR, $conLogic = 'AND') {
        $this->SetCondition($field, $value, '!=', $dataType, $conLogic);
        return $this;
    }

    /**
	* Less Than Condition for DBPDO Parameter
	*
	* set condition for less than '<'
	*
    * @access   public
	* @param    string
	* @param    mixed
	* @param    PDO_PARAM
	* @param    string
	* @return   DBPDO object
	*/
	public function LessThan($field, $value, $data_type = PDO::PARAM_STR, $con_logic = 'AND') {
		$this->SetCondition($field, $value, '<', $data_type, $con_logic);
        return $this;
	}

    /**
	* Less Equal Than Condition for DBPDO Parameter
	*
	* set condition for less than '<='
	*
	* @access   public
    * @param    string
	* @param    mixed
	* @param    PDO_PARAM
	* @param    string
	* @return   DBPDO object
	*/
	public function LessEqualThan($field, $value, $data_type = PDO::PARAM_STR, $con_logic = 'AND') {
		$this->SetCondition($field, $value, '<=', $data_type, $con_logic);
        return $this;
	}

    /**
	* More Than Condition for DBPDO Parameter
	*
	* set condition for more than '>'
	*
    * @access   public
	* @param    string
	* @param    mixed
	* @param    PDO_PARAM
	* @param    string
	* @return   DBPDO object
	*/
	public function MoreThan($field, $value, $data_type = PDO::PARAM_STR, $con_logic = 'AND') {
		$this->SetCondition($field, $value, '>', $data_type, $con_logic);
        return $this;
	}

    /**
	* More Equal Than Condition for DBPDO Parameter
	*
	* set condition for less than '>='
	*
    * @access   public
	* @param    string
	* @param    mixed
	* @param    PDO_PARAM
	* @param    string
	* @return   DBPDO object
	*/
	public function MoreEqualThan($field, $value, $data_type = PDO::PARAM_STR, $con_logic = 'AND') {
		$this->SetCondition($field, $value, '>=', $data_type, $con_logic);
        return $this;
	}

    /**
	* Order By Condition for DBPDO Parameter
	*
	* set order by condition
	*
    * @access   public
	* @param    string
	* @return   DBPDO object
	*/
	public function OrderBy($fieldName , $order = "ASC") {
		array_push($this->orderFields, $fieldName . " " . $order);
        return $this;
	}

    /**
     * Join Table for DBPDO
     *
     * join table
     *
     * @access public
     * @param  string
     * @param  string
     * @param  string
     * @return DBPDO
     */
    public function Join($tableName, $key1, $key2, $joinType = 'INNER JOIN') {
        array_push($this->joinCondition, " $joinType $tableName ON $key1 = $key2 ");
        return $this;
    }

    /**
	* Bind Insert Value for DBPDO Parameter
	*
	* set value that want to insert
	*
    * @access   public
	* @param    string
	* @param    mixed
	* @param    PDO_PARAM
	* @return   void
	*/
	public function BindInsertParam($field, $value, $dataType = PDO::PARAM_STR) {
		$paramName = ":dbPDOParam" . (count($this->parameterCondition) + 1);
		$param['name'] = $paramName;
		$param['value'] = $value;
		$param['dataType'] = $dataType;
		array_push($this->parameterCondition, $param);
		array_push($this->insertFields, $field);
	}

    /**
	* Insert Data for DBPDO Parameter
	*
	* execute insert query
	*
	* @access   public
    * @param    string
	* @param    array
	* @return   DBPDO object
	*/
	public function Insert($table) {
		$query = 'INSERT INTO ' . $table . "(" . implode(', ', $this->insertFields) . ") VALUES (";

		for($i=0; $i<count($this->parameterCondition); $i++) {
			if($i!=0)
				$query .= ", ";

			$query .= $this->parameterCondition[$i]['name'];
		}

		$query .= ')';

		$stmt = $this->prepare($query);

		foreach($this->parameterCondition as $param){
			$stmt->bindParam($param['name'], $param['value'], $param['dataType']);
		}

        try {
            if(!$stmt->execute())
                throw new CustomException();
            $this->ResetCondition();
        }
        catch(CustomException $e) {
            $errMessage = $stmt->errorInfo();
            $e->ShowError('Database Error', $errMessage[2]);
        }

        return $this;
	}

    /**
	* Bind Update Value for DBPDO Parameter
	*
	* set value that want to update
	*
    * @access   public
	* @param    string
	* @param    mixed
	* @param    PDO_PARAM
	* @return   void
	*/
    public function BindUpdateParam($field, $value, $dataType = PDO::PARAM_STR) {
		if($this->updateCondition != '')
			$this->updateCondition .= ", ";

		$paramName = ":dbPDOParam" . (count($this->parameterCondition) + 1);
		$this->updateCondition .= " $field = $paramName";
		$param['name'] = $paramName;
		$param['value'] = $value;
		$param['dataType'] = $dataType;
		array_push($this->parameterCondition, $param);
	}

    /**
	* Update Data for DBPDO Parameter
	*
	* execute update query include condition that set before
	*
	* @access   public
    * @param    string
	* @param    array
	* @return   void
	*/
    public function Update($table) {
		$query = 'UPDATE ' . $table . " SET " . $this->updateCondition;

		if($this->queryCondition != '')
			$query .= ' WHERE ' . $this->queryCondition;

		$stmt = $this->prepare($query);

		foreach($this->parameterCondition as $param){
			$stmt->bindParam($param['name'], $param['value'], $param['dataType']);
		}

        try {
            if(!$stmt->execute())
                throw new CustomException();
            
            $this->ResetCondition();
        }
        catch(CustomException $e) {
            $errMessage = $stmt->errorInfo();
            $e->ShowError('Database Error', $errMessage[2]);
        }
	}

    /**
	* Update Data for DBPDO Parameter
	*
	* execute update query use last condition
	*
	* @access   public
    * @param    string
	* @param    array
	* @return   void
	*/
    public function UpdateWithLastCondition($table) {
		$query = 'UPDATE ' . $table . " SET " . $this->updateCondition;

        $lastCondition  = str_replace(':dbPDOParam', ':tempDBPDOParam', $this->lastCondition);
		if($lastCondition != '')
			$query .= ' WHERE ' . $lastCondition;

		$stmt = $this->prepare($query);

		foreach($this->lastParameterCondition as $param){
            $param['name'] = str_replace(':dbPDOParam', ':tempDBPDOParam', $param['name']);
            $stmt->bindParam($param['name'], $param['value'], $param['dataType']);
		}

        
        foreach($this->parameterCondition as $param) {
            $stmt->bindParam($param['name'], $param['value'], $param['dataType']);
        }
        
        try {
            if(!$stmt->execute())
                throw new CustomException();
            
            $this->ResetCondition();
        }
        catch(CustomException $e) {
            $errMessage = $stmt->errorInfo();
            $e->ShowError('Database Error', $errMessage[2]);
        }
	}

    /**
	* Delete Data for DBPDO Parameter
	*
	* execute delete query include condition that set before
	*
	* @access   public
    * @param    string
	* @param    array
	* @return   void
	*/
    public function Delete($table) {
		$query = 'DELETE FROM ' . $table;

		if($this->queryCondition != '')
			$query .= ' WHERE ' . $this->queryCondition;

		$stmt = $this->prepare($query);

		foreach($this->parameterCondition as $param){
			$stmt->bindParam($param['name'], $param['value'], $param['dataType']);
		}

        try {
            if(!$stmt->execute())
                throw new CustomException();

            $this->ResetCondition();
        }
        catch(CustomException $e) {
            $errMessage = $stmt->errorInfo();
            $e->ShowError('Database Error', $errMessage[2]);
        }
	}

    /**
     * Last Query
     *
     * get last query
     *
     * @access public
     * @return string
     */
    public function LastQuery($die = TRUE) {
        $e  = new CustomException();
        $e->ShowError('LAST EXECUTED QUERY', $this->lastQuery, 500, $die);
    }

    /**
     * Query
     *
     * run custom query
     * 
     * @param  $sql
     * @return void
     */
    public function Query($sql) {
        return $this->query($sql);
    }

    /**
	* Set Condition
	*
	* set condition that connect with get result
	*
    * @access   private
	* @param    string
	* @param    mixed
	* @param    string
	* @param    PDO_PARAM
	* @param    string
	* @return   DBPDO object
	*/
    private function SetCondition($field, $value, $condition, $dataType, $conLogic) {
        if($this->queryCondition != '')
            $this->queryCondition .= " $conLogic ";

        $paramName               = ":dbPDOParam" . (count($this->parameterCondition) + 1);
        $this->queryCondition   .= " $field $condition $paramName";
        $param                   = array();
        $param['name']           = $paramName;
        $param['value']          = $value;
        $param['dataType']       = $dataType;
        array_push($this->parameterCondition, $param);
    }

    /**
	* Reset Condition
	*
	* reset condition that connect with get result
	*
    * @access   protected
	* @return   DBPDO object
	*/
    protected function ResetCondition() {
        $this->queryCondition       = '';
        $this->updateCondition      = '';
        $this->insertFields         = array();
        $this->joinCondition        = array();
        $this->parameterCondition   = array();
        $this->orderFields          = array();
        $this->limit['offset']      = -1;
        $this->limit['rowCount']    = -1;
    }
    
}
?>