<?php

class ApiApplication extends PApplication
{
    /**
     * @var ApiRouter
     */
    public $router;
    
    function __construct()
    {
        $this->router = new ApiRouter($_SERVER['REQUEST_URI']);
    }
}