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
    
    public function add($notebookId, $content)
    {
        $data = array(
                'notebook_id' => $notebookId,
                'content' => $content
        );
        return $this->insert($data, 't_note');
    }
    
    public function remove($noteId)
    {
        if (empty($noteId)) {
            return TRUE;
        }
    
        $data = array(
        '_note_id' => $noteId,
        );
        $sql = "UPDATE t_note SET status=-1 WHERE note_id=:_note_id LIMIT 1";
        $this->query($sql, $data);
        return TRUE;
    }
    
    public function update_content($noteId, $content)
    {
        if (empty($noteId)) {
            return TRUE;
        }
    
        $data = array(
                '_note_id' => $noteId,
                'content' => $content
        );
        $sql = "UPDATE t_note SET content=:content, update_time=NOW(), version=version+1
                WHERE note_id=:_note_id LIMIT 1";
        $this->query($sql, $data);
        return TRUE;
    }
    
    public function get($noteId)
    {
        if (empty($noteId)) {
            return array();
        }
    
        $data = array('_note_id' => $noteId);
        $sql = "SELECT * FROM t_note WHERE note_id=:_note_id";
        $result = $this->query($sql, $data);
        return isset($result[0]) ? $result[0] : array();
    }
    
    public function get_list_by_notebook_id($notebookId)
    {
        if (empty($notebookId)) {
            return array();
        }
    
        $data = array('_notebook_id' => $notebookId);
        $sql = "SELECT * FROM t_note WHERE notebook_id=:_notebook_id AND status>-1";
        return $this->query($sql, $data);
    }
}