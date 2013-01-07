<?php
class ApiController extends PController
{
    public function render($response)
    {
        echo json_encode($response);
    }
}