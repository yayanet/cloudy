<?php
/**
 * @author yang yu
 */

require_once LIBS_PATH . "smarty/Smarty.class.php";

class PSmarty extends Smarty{
    function __construct()
    {
        parent::__construct();

        global $config;
        $this->template_dir = $config['smarty']['template_dir'];
        $this->compile_dir = $config['smarty']['compile_dir'];
        $this->cache_dir = $config['smarty']['cache_dir'];
        $this->caching = false;
        $this->cache_lifetime = $config['smarty']['lifetime'];
        $this->compile_check = true;

        $this->assign('BASE_URL', BASE_URL);
        $this->assign('COOKIE_DOMAIN' , $config['cookie']['domain']);
        $this->assign('COOKIE_PATH' , $config['cookie']['path']);
        $this->assign('WEB_TITLE', $config['website']['default_title']);
        $this->assign('WEB_KEYWORDS', $config['website']['default_keywords']);
        $this->assign('WEB_DESCRIPTION', $config['website']['default_description']);
        $this->assign('STATIC_FILE_VERSION', STATIC_FILE_VERSION);
    }
}