<?php
class IndexController extends PController
{
    public function index()
    {
        header('Location: /note');
    }
}