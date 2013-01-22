<?php

class PController
{
    var $smarty = NULL;
    var $smarty_debug = FALSE;

    static public $sessionId    = NULL;
    static public $userId       = NULL;
    static public $clientId     = NULL;
    
	function __construct()
	{
        $this->init_smarty();
        $this->init_session();
	}
	
	function call_method($methodName, $parameters) {
	    $methodName = strtolower($methodName);

        if (! method_exists($this, $methodName) && method_exists($this, $methodName . '_')) {
            $methodName = $methodName . '_';
        }    

	    if (method_exists($this, $methodName)) {
	        call_user_func_array(array($this, $methodName), $parameters);
	    }
	    else {
	        PUtil::page_not_found();
	    }
	}


    public function is_submit()
    {
        return isset($_REQUEST['is_submit']);
    }

    public function is_ajax()
    {
        return isset($_REQUEST['is_ajax']);
    }
	
	////////////////////////////////////////////////////////////////////////////
	// For display
	////////////////////////////////////////////////////////////////////////////
	
	public function assign($key, $value, $debug = FALSE)
	{
	    $this->smarty->assign($key, $value);
	
	    if ($debug OR $this->smarty_debug) {
	        echo "<pre>";
	        echo "------ $key ------\n";
	        var_dump($value);
			echo "</pre>";
	    }
	}
	
	/**
	*
	* @param string $contentTpl   content template name, if not given, $currentAction/$currentMethod.html will be instead.
    * @param bool   $useFrame 
	*/
    public function display($contentTpl = '', $useFrame = TRUE)
    {
        // TODO: Assign common varibles(user id, nickname etc.)
        

        // Content template
        if (empty($contentTpl)) {
            global $application;
            $contentTpl = strtolower($application->router->controllerName . '/' . $application->router->methodName . '.html');
        }

        // Display
        if ($useFrame) {
            $this->smarty->assign('content_tpl_file', $contentTpl);
            $this->smarty->display('frame.html');
        }
        else {
            $this->smarty->display($contentTpl);
        }
    }

    public function set_page_title($pageTitle, $needSuffix = TRUE)
    {
        if ($needSuffix) {
            global $config;
            $pageTitle .= " - " . $config['website']['name'];
        }

        $this->assign('WEB_TITLE', $pageTitle);
    }

    protected function init_smarty()
    {
	    // Create smarty instance
	    $this->smarty = new PSmarty();
    }

    //////////
    protected function init_session()
    {
        if (empty($_COOKIE['cloudy_session'])) {
            $this->create_temporary_session();
            return;
        }

        $sessionId = $_COOKIE['cloudy_session'];
        $session = SessionModel::getInstance()->get_by_id($sessionId);
        if (! empty($session)) {
 
            self::$sessionId = $session['session_id'];
            self::$userId = $session['user_id'];
            self::$clientId = $session['client_id'];
        }
        else {
            self::$sessionId = $sessionId;
            self::$userId = 0;
            self::$clientId = 1;
        }
    }

    protected function create_temporary_session()
    {
        $sessionId = p_get_unique_id();
        PUtil::set_cookie('cloudy_session', $sessionId);
        
        self::$sessionId = $sessionId;
        self::$userId = 0;
        self::$clientId = 1;
    }
}
