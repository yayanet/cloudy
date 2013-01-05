<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage PluginsFunction
 */

/**
 * Smarty {include_css} function plugin
 *
 * Type:     function<br>
 * Name:     include_css<br>
 * Purpose:  print out a counter value
 *
 * @author yangyu
 * @param array                    $params   parameters
 * @param Smarty_Internal_Template $template template object
 * @return string|null
 */
function smarty_function_include_css($params, $template)
{
	$output = '';
	
	if (! empty($params['file'])) {
		$file = $params['file'] . '.css?v=' . STATIC_FILE_VERSION;
		$output = '<link rel="stylesheet" type="text/css" href="/css/' . $file . '" />';
	}
	
    return $output;
}

?>