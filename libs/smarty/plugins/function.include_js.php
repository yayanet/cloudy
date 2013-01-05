<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {include_js} function plugin
 *
 * Type:     function<br>
 * Name:     include_js<br>
 * Purpose:  print out a counter value
 *
 * @author yangyu
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 * @return string|null
 */
function smarty_function_include_js($params, $template)
{
	$output = '';
	
	if (! empty($params['file'])) {
		$file = $params['file'] . '.js?v=' . STATIC_FILE_VERSION;
		$output = '<script type="text/javascript" src="/js/' . $file . '"></script>';
	}
	
    return $output;
}

?>