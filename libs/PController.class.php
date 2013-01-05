<?php

class PController
{
    var $smarty = NULL;
    var $smarty_debug = FALSE;
    
	function __construct()
	{
	    // Create smarty instance
	    $this->smarty = new PSmarty();
	}
	

	function call_method($methodName, $parameters) {
	
	    if (empty($methodName)) {
	        // TODO: Default method name
	        $methodName = 'index';
	    }
	    
	    $methodName = strtolower($methodName);
	    
	    if (method_exists($this, $methodName)) {
	        call_user_func_array(array($this, $methodName), $parameters);
	    }
	    else {
	        PUtil::page_not_found();
	    }
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
	* @param string $content_tpl   content template name, if not given, $currentAction/$currentMethod.html will be instead.
	*/
    public function display($content_tpl = '')
    {
        // TODO: Assign common varibles(user id, nickname etc.)

        // Content template
        if (empty($content_tpl)) {
            global $application;
            $contentTpl = $application->controllerName . '/' . $application->methodName . '.html';
        }
        $this->smarty->assign('content_tpl_file', $contentTpl);

        // Display
        $this->smarty->display('frame.html');
    }

    public function setPageTitle($page_title, $needSuffix = TRUE)
    {
        if ($needSuffix) {
            global $config;
            $page_title .= " - " . $config['website']['name'];
        }

        $this->assign('WEB_TITLE', $page_title);
    }
}