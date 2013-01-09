<?php

class SessionModel extends PModel
{
    /**
     * @return SessionModel
     */
    static public function getInstance()
    {
        return parent::getInstance(get_class());
    }
    
    public function add($sessionId, $clientId, $userId = 0)
    {
        if (empty($sessionId)) {
            return FALSE;
        }
        
        $data = array(
                'session_id' => $sessionId,
                'user_id' => $userId,
                'client_id' => $clientId,
        );
        return $this->insert($data, 't_session');
    }
    
    public function update_user_id($sessionId, $userId)
    {
        if (empty($sessionId)) {
            return FALSE;
        }
        
        $sql = "UPDATE t_session SET user_id=:_user_id WHERE session_id=:session_id LIMIT 1";
        $params = array(
                'session_id' => $sessionId,
                '_user_id' => $userId
                );
        $this->query($sql, $params);
        return TRUE;
    }
    
    public function get_by_id($sessionId)
    {
        if (empty($sessionId)) {
            return NULL;
        }
        
        $params = array('session_id' => $sessionId);
        $result = $this->query("SELECT * FROM t_session WHERE session_id=:session_id", $params);
        return isset($result[0]) ? $result[0] : NULL;
    }

    function get_by_id_and_user_id($sessionId, $userId)
    {
        if (empty($sessionId) OR empty($userId)) {
            return NULL;
        }
    
        $params = array(
                'session_id' => $sessionId,
                '_user_id' => $userId,
        );
        $sql = "SELECT * FROM t_session WHERE session_id=:session_id AND user_id=:_user_id";
        $result = $this->query($sql, $params);
        return isset($result[0]) ? $result[0] : NULL;
    }
}