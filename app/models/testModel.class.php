<?php
class testModel extends PModel
{
    /**
     * @return testModel 
     */
    static public function getInstance()
    {
        return parent::getInstance(get_class());
    }
    
    public function getTestList()
    {
        $sql = "SELECT * FROM test LIMIT 20";
        return $this->query($sql);
    }
    
    public function getTestListByName($name)
    {
        $sql = "SELECT * FROM test WHERE name=:name LIMIT 1";
        return $this->query($sql, array('name' => $name));
    }
}