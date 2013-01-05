<?php

if(! function_exists("__autoload")){
    function pautoload($class){
        
        if (! class_exists($class) AND strpos($class, "Model") !== false ){
            require_once(APP_PATH . "models/".$class.".class.php");
            return TRUE;;
        }
        
        $class_file = LIBS_PATH . $class . '.class.php';
        if (! class_exists($class) AND file_exists($class_file)) {
            require_once $class_file;
            return TRUE;
        }
    }

    spl_autoload_register('pautoLoad');
}