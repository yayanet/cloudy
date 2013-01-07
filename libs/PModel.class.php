<?php
require_once 'PPDO.class.php';

class PModel
{
    /**
     * @var PPDO
     */
	public $db = NULL;
	
	/**
	 * @var PDOStatement
	 */
	private $lastStatement = NULL;
	
	static protected function getInstance($class)
	{
	    static $instances = array();  // array of instance names
        
        if (!array_key_exists($class, $instances)) {
            // instance does not exist, so create it
            $instances[$class] = new $class;
        }
        
        return $instances[$class];
	}
	
	
	public function __construct()
	{
	    static $sharedDB = NULL;
	    if ($sharedDB == NULL) {
	        $sharedDB = new PPDO();
	    }
	    $this->db = $sharedDB;
	}
	
	protected function query($sql, $parameters = array())
	{
	    $statement = $this->db->prepare($sql);
	    $this->lastStatement = $statement;
	    
	    foreach ($parameters as $key => $value) {
	        if (substr($key, 0, 1) == '_') {
				$statement->bindValue(":{$key}", $value, PDO::PARAM_INT);
			}
			else {
				$statement->bindValue(":{$key}", $value, PDO::PARAM_STR);
			}
	    }
	    
	    $statement->execute();
	    
	    if (strtoupper(strtok($sql, ' ')) === 'SELECT') {
	        return $statement->fetchAll(PDO::FETCH_ASSOC);
	    }
	    else {
	        return NULL;
	    }
	}
	
	protected function insert($data, $tableName)
	{
	    if (empty($data) OR empty($tableName)) {
	        return FALSE;
	    }
	    
	    $fields = '';
	    $values = '';
	    
	    foreach ($data as $k => $v) {
	        $fields .= ", `{$k}`";
	        $values .= ", :{$k}";
	    }
	    $fields = substr($fields, 2);
	    $values = substr($values, 2);
	    
	    $sql = "INSERT INTO {$tableName} ({$fields}) VALUES ({$values})";
	    $this->query($sql, $data);
	    
	    $insertId = $this->insert_id();
	    return empty($insertId) ? TRUE : $insertId;
	}
	
	protected function affected_rows()
	{
	    return $this->lastStatement->rowCount();
	}
	
	protected function insert_id()
	{
	    return $this->db->lastInsertId();
	}
	
	////////////////////////////////////////////////////////////////
	
}