<?php
class ApiController extends PController
{
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
    
    public function invalid_request($message = '')
    {
        $response = array('error' => 'invalid_request');
        if (! empty($message)) {
            $response['message'] = $message;
        }
        $this->render($response);
    }
    
    public function check_parameters()
    {
        $params = func_get_args();
        
        foreach ($params as $parameter) {
            if (empty($_REQUEST[$parameter])) {
                $this->invalid_request($parameter . ' cannot be empty');
                return FALSE;
            }
        }
        
        return TRUE;
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

    protected function init_smarty()
    {
        // Just for replacing the default action,
        // because we don't need smarty here
    }

    protected function init_session()
    {
        if (empty($_REQUEST['session_id'])) return;

        $sessionId = $_REQUEST['session_id'];
        $session = SessionModel::getInstance()->get_by_id($_REQUEST['session_id']);
        if (! empty($session)) {
            self::$sessionId = $session['session_id'];
            self::$userId = $session['user_id'];
            self::$clientId = $session['client_id'];
        }
    }
    
    /////
    
    protected function check_session_id()
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
        
        if (empty(self::$sessionId)) {
            $this->render(array('error' => 'invalid_session_id'));
            return FALSE;
        }

        return TRUE;
    }
}
