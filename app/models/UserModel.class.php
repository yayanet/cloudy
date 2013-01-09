<?php
class UserModel extends PModel
{
    /**
     * @return userModel 
     */
    static public function getInstance()
    {
        return parent::getInstance(get_class());
    }
    
    function add($email, $password)
    {
        if (empty($email) OR empty($password)) {
            return FALSE;
        }
        
        $data = array(
                'email' => $email,
                'password' => md5($password),
                );
        return $this->insert($data, 't_user');
    }
    
    function get_by_id($userId)
    {
        if (empty($userId)) {
            return NULL;
        }
        
        $params = array('_user_id' => $userId);
        $result = $this->query("SELECT * FROM t_user WHERE user_id=:_user_id", $params);
        return isset($result[0]) ? $result[0] : NULL;       
    }
    
    function get_by_email($email)
    {
        if (empty($email)) {
            return NULL;
        }
        
        $params = array('email' => $email);
        $result = $this->query("SELECT * FROM t_user WHERE email=:email", $params);
        return isset($result[0]) ? $result[0] : NULL;
    }
    
    function get_by_email_and_password($email, $password)
    {
        if (empty($email) OR empty($password)) {
            return NULL;
        }
        
        $params = array(
                'email' => $email,
                'password' => md5($password),
                );
        $sql = "SELECT * FROM t_user WHERE email=:email AND password=:password";
        $result = $this->query($sql, $params);
        return isset($result[0]) ? $result[0] : NULL;
    }
}