<?php
class IndexController extends PController
{
    public function index($name = 'Cloudy')
    {
        $this->assign('message', "Hello {$name}!");
        
        $this->display();
    }
}