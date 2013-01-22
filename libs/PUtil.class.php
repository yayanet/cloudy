<?php
// TODO: Rename to PUtility
class PUtil
{
    static function page_not_found()
    {
        header ( "HTTP/1.1 404 Not Found" );
        // TODO: Load 404 page from templates
        echo '<h1>Page Not Found</h1>';
        exit ();
    }

    static function set_cookie($key, $value, $expire = 0)
    {
        global $config;

        setcookie($key, $value, $expire, $config['cookie']['path'], $config['cookie']['domain']);
    }
}
