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
    
    public function add($name, $userId)
    {
        $data = array(
            'name' => $name,
            'user_id' => $userId
            );
        return $this->insert($data, 't_notebook');
    }

    public function remove($notebookId)
    {
        if (empty($notebookId)) {
            return TRUE;
        }

        $data = array('_notebook_id' => $notebookId);
        $sql = "DELETE FROM t_notebook WHERE notebook_id=:_notebook_id LIMIT 1";
        $this->query($sql, $data);
        return TRUE;
    }

    public function update_name($notebookId, $name)
    {
        if (empty($notebookId)) {
            return TRUE;
        }

        $data = array(
            '_notebook_id' => $notebookId,
            'name' => $name
            );
        $sql = "UPDATE t_notebook SET name=:name WHERE notebook_id=:_notebook_id LIMIT 1";
        $this->query($sql, $data);
        return TRUE;
    }

    public function get($notebookId)
    {
        if (empty($notebookId)) {
            return array();
        }

        $data = array('_notebook_id' => $notebookId);
        $sql = "SELECT * FROM t_notebook WHERE notebook_id=:_notebook_id";
        $result = $this->query($sql, $data);
        return isset($result[0]) ? $result[0] : array();
    }

    public function get_list_by_user_id($userId)
    {
        if (empty($userId)) {
            return array();
        }

        $data = array('_user_id' => $userId);
        $sql = "SELECT * FROM t_notebook WHERE user_id=:_user_id";
        return $this->query($sql, $data);
    }
}
