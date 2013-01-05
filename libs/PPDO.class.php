<?php
class PPDO extends PDO
{
    function __construct($driver = 'mysql')
    {
        global $config;
        $settings = $config[$driver];
        
        $dns = $driver .
        ':host=' . ((! empty($settings['host'])) ? $settings['host'] : '127.0.0.1'). 
        ((! empty($settings['port'])) ? (';port=' . $settings['port']) : '') .
        ';dbname=' . $settings['name'];
        
        $options = array();
        
        if ($driver == 'mysql') {
            $options = array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8;',
                    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => TRUE
                    );
        }
        
        parent::__construct($dns, $settings['user'], $settings['pass'], $options);
        
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}