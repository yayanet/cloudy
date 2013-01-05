<?php

class PApplication
{
    public $router        = NULL;
    public $controller    = NULL;
    
    public $controllerName    = '';
    public $methodName        = '';
    
	function __construct()
	{
        $this->router = new PRouter($_SERVER['REQUEST_URI']);
        $this->controllerName = p_string($this->router->piecesOfURL, 0);
        if (empty($this->controllerName)) {
            $this->controllerName = 'Index';
        }
        $this->methodName = p_string($this->router->piecesOfURL, 1);
        if (empty($this->methodName)) {
            $this->methodName = 'Index';
        }
	}
	
	public function run()
	{
	    if ($this->router->controller_exists()) {
	        $this->controller = $this->router->create_controller();
	        $parameters = array_slice($this->router->piecesOfURL, 2);
	        $this->controller->call_method($this->methodName, $parameters);
	    }
	    else {
	        PUtil::page_not_found();
	    }
	}
}