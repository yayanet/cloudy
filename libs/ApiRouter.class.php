<?php

class ApiRouter extends PRouter
{
    public $apiVersion;
    
    function __construct($uri)
    {
        parent::__construct($uri);
        
        $this->_set_api_version();
    }
    
    ////////////////////////////////////////////////////////////////////
    
    protected function _controller_class_path()
    {
        $className = ucfirst($this->controllerName) . 'Controller';
        return APP_PATH . 'controllers_api/' . $className . '.class.php';
    }
    
    protected function _set_api_version()
    {
        $this->apiVersion = floatval(p_string($this->piecesOfURL, 0));
        if (empty($this->apiVersion)) {
            $this->apiVersion = 1.0;
        }
    }
    
    protected function _set_controller_name()
    {
        $this->controllerName = p_string($this->piecesOfURL, 1);
        if (empty($this->controllerName)) {
            $this->controllerName = 'Index';
        }
    }
    
    protected function _set_method_name()
    {
        $this->methodName = p_string($this->piecesOfURL, 2);
        if (empty($this->methodName)) {
            $this->methodName = 'Index';
        }
    }
    
    protected function _set_paramaters()
    {
        $this->parameters = array_slice($this->piecesOfURL, 3);
    }
} 