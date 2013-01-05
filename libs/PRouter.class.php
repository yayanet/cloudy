<?php

class PRouter
{
    public $piecesOfURL;
    
    function __construct($uri)
    {
        $pieces = explode('/', strtok($uri, '?'));
        $pieces = array_filter($pieces);
        $this->piecesOfURL = array_values($pieces);
    }
    
    public function controller_exists()
    {
        $controller_path = APP_PATH . 'controllers/' . $this->_controller_class_name() . '.class.php';
        return file_exists($controller_path);
    }
    
    public function create_controller()
    {
        $controller_path = APP_PATH . 'controllers/' . $this->_controller_class_name() . '.class.php';
        require_once $controller_path;
        
        $controller_name = $this->_controller_class_name();
        $controller = new $controller_name();
        return $controller;
    }
    
    ////////////////////////
    
    private function _controller_class_name()
    {
        if (! empty($this->piecesOfURL[0])) {
            $name = ucfirst($this->piecesOfURL[0]);
            return $name . 'Controller';
        }
        else {
            // TODO: Default controller name
            return 'IndexController';
        }
    }
}