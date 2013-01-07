<?php

class PApplication
{
    /**
     * @var PRouter
     */
    public $router        = NULL;

    /**
     * @var PController
     */
    public $controller    = NULL;
    
	function __construct()
	{
        $this->router = new PRouter($_SERVER['REQUEST_URI']);
	}
	
	public function run()
	{
	    if ($this->router->controller_exists()) {
	        $this->controller = $this->router->create_controller();
	        $this->controller->call_method($this->router->methodName, $this->router->parameters);
	    }
	    else {
	        PUtil::page_not_found();
	    }
	}
}