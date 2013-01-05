<?php

$server_name = 'http://' . $_SERVER['SERVER_NAME'];
$server_name .= ($_SERVER['SERVER_PORT'] == '80') ? '/' : $_SERVER['SERVER_PORT'] . '/';

define('BASE_URL', $server_name);

// Smarty config
$config['smarty']['template_dir']    = APP_PATH . 'templates/';
$config['smarty']['compile_dir']     = DATA_PATH . 'smarty_compile/';
$config['smarty']['cache_dir']       = DATA_PATH . 'smarty_cache/';
$config['smarty']['lifetime']        = 0;

//
define('STATIC_FILE_VERSION', '' . time());

// Cookie
$config['cookie']['domain']    = $_SERVER['SERVER_NAME'];
$config['cookie']['path']      = '/';

// Website config
$config['website']['name']    = 'A Patrick Web';
$config['website']['default_title']       = $config['website']['name'];
$config['website']['default_keywords']    = '';
$config['website']['default_description'] = '';
