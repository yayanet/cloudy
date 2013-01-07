<?php

class PRouter
{
    public $controllerName;
    public $methodName;
    public $parameters;
    
    protected $piecesOfURL;
    
    function __construct($uri)
    {
        $pieces = explode('/', strtok($uri, '?'));
        $pieces = array_filter($pieces);
        $this->piecesOfURL = array_values($pieces);
        
        $this->_set_controller_name();
        $this->_set_method_name();
        $this->_set_paramaters();
    }
    
    public function controller_exists()
    {
        return file_exists($this->_controller_class_path());
    }
    
    public function create_controller()
    {
        require_once $this->_controller_class_path();
        
        $className = ucfirst($this->controllerName) . 'Controller';
        $controller = new $className();
        return $controller;
    }
    
    ////////////////////////////////////////////////////////////////////
    
    protected function _controller_class_path()
    {
        $className = ucfirst($this->controllerName) . 'Controller';
        return APP_PATH . 'controllers/' . $className . '.class.php';
    }
    
    protected function _set_controller_name()
    {
        $this->controllerName = p_string($this->piecesOfURL, 0);
        if (empty($this->controllerName)) {
            $this->controllerName = 'Index';
        }
    }
    
    protected function _set_method_name()
    {
        $this->methodName = p_string($this->piecesOfURL, 1);
        if (empty($this->methodName)) {
            $this->methodName = 'Index';
        }
    }
    
    protected function _set_paramaters()
    {
        $this->parameters = array_slice($this->piecesOfURL, 2);
    }
}