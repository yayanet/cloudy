<?php
class NoteModel extends PModel
{
    /**
     * @return noteModel 
     */
    static public function getInstance()
    {
        return parent::getInstance(get_class());
    }
    
}