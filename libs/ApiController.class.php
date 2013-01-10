<?php
class ApiController extends PController
{
    static public $sessionId    = NULL;
    static public $userId       = NULL;
    static public $clientId     = NULL;
    
    public function render($response)
    {
        echo json_encode($response);
    }

    public function error($errorName)
    {
        $this->render(array('error' => $errorName));
    }

    public function permission_denied()
    {
        $this->error('permission_denied');
    }
    
    public function invalid_request()
    {
        $response = array('error' => 'invalid_request');
        $params = func_get_args();
        if (! empty($params)) {
            $response['message'] = implode(', ', $params) . ' cannot be empty';
        }
        $this->render($response);
    }
    
    public function check_login()
    {
        if (empty(self::$userId)) {
            $this->render(array('error' => 'login_required'));
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
    
    ////// Override 
    function call_method($methodName, $parameters) {
        $methodName = strtolower($methodName); 

        if (! method_exists($this, $methodName) && method_exists($this, $methodName . '_')) {
            $methodName = $methodName . '_';
        }

        if (method_exists($this, $methodName)) {
            
            // Check session id
            if ($this->check_session_id()) {
                call_user_func_array(array($this, $methodName), $parameters);                
            }
        }
        else {
            PUtil::page_not_found();
        }
    }
    
    /////
    
    private function check_session_id()
    { 
        global $application;
        $method = strtolower($application->router->controllerName . '/' . $application->router->methodName);
        $excludeMethods = array('account/session');
        
        if (in_array($method, $excludeMethods)) {
            return TRUE;
        }

        if (empty($_REQUEST['session_id'])) {
            $this->render(array('error' => 'session_id_cannot_be_empty'));
            return FALSE;
        }
        
        $session = SessionModel::getInstance()->get_by_id($_REQUEST['session_id']);
        if (empty($session)) {
            $this->render(array('error' => 'invalid_session_id'));
            return FALSE;
        }
        
        self::$sessionId = $session['session_id'];
        self::$userId = $session['user_id'];
        self::$clientId = $session['client_id'];
        
        return TRUE;
    }
}
