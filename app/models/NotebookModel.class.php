<?php
class NotebookModel extends PModel
{
    /**
     * @return notebookModel 
     */
    static public function getInstance()
    {
        return parent::getInstance(get_class());
    }
    
}