<?php
class IndexController extends ApiController
{
    public function index()
    {
        $response = array('message' => 'Hello Cloudy!');
        $this->render($response);
    }
}