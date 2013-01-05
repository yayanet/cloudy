<?php
class PUtil
{
    static function page_not_found()
    {
        header ( "HTTP/1.1 404 Not Found" );
        // TODO: Load 404 page from templates
        echo '<h1>Page Not Found</h1>';
        exit ();
    }
}