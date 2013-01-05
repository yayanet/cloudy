<?php
class IndexController extends PController
{
    public function index()
    {
        $this->assign('message', 'Hello Patrick!');
        
        $this->display();
    }
}