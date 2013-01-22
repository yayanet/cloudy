<?php
class IndexController extends PController
{
    public function index()
    {
        header('Location: /note');
    }

    public function test()
    {
        echo 'test';
        echo self::$sessionId;
        var_dump(self::$userId);
        var_dump(self::$clientId);
    }
}
