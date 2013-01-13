<?php

class AccountController extends ApiController
{
    public function session()
    {
        if (! $this->check_parameters('client_id')) return;
        
        // TOOD: check client id
        
        $sessionId = p_get_unique_id();
        $success = SessionModel::getInstance()->add($sessionId, intval($_REQUEST['client_id']));
        if ($success) {
            $response = array('session_id' => $sessionId);
        }
        else {
            $response = array('error' => 'unknown_error');
        }
        $this->render($response);
    }
    
    public function login()
    {
        if (! $this->check_parameters('email', 'password')) return;
        
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        
        $user = UserModel::getInstance()->get_by_email($email);
        if (empty($user)) {
            $response = array('error' => 'email_does_not_exists');
        }
        else {
            $user = UserModel::getInstance()->get_by_email_and_password($email, $password);
            if (empty($user)) {
                $response = array('error' => 'invalid_password');
            }
            else {
                // Login
                $success = SessionModel::getInstance()->update_user_id(self::$sessionId, $user['user_id']);
                if ($success) {
                    $responseUser = array(
                            'user_id' => $user['user_id'],
                            'email' => $user['email'],
                            );
                    $response = array('user' => $responseUser);
                }
                else {
                    $response = array('error' => 'login_failed');
                }
            }
        }
        
        $this->render($response);
    }
    
    public function logout()
    {
        $success = SessionModel::getInstance()->update_user_id(self::$sessionId, 0);
        if ($success) {
            $response = array('result' => 'success');
        }
        else {
            $response = array('error' => 'logout_failed');
        }
        
        $this->render($response);
    }
}
