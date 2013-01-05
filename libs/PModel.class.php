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
	
	public function query($sql, $parameters = array())
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
	    
	    return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function affected_rows()
	{
	    return $this->lastStatement->rowCount();
	}
	
	////////////////////////////////////////////////////////////////
	
// 	private function _
}