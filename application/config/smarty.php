<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CI Smarty
 *
 * Smarty templating for Codeigniter
 *
 * @package   CI Smarty
 * @author    Dwayne Charrington
 * @copyright Copyright (c) 2012 Dwayne Charrington and Github contributors
 * @link      http://ilikekillnerds.com
 * @license   http://www.apache.org/licenses/LICENSE-2.0.html
 * @version   1.2
 */

// Your views directory with a trailing slash
$config['template_directory'] = array(
	APPPATH."views"
);

// Should we traverse your application/views directory for sub-folders
// in-case you want to use template inheritance and the master template
// is in a sub-folder. true means on and false means off.
$config['traverse_view_directories'] = TRUE;

// Smarty caching enabled by default unless explicitly set to 0
$config['cache_status']         = 1;

// Cache lifetime. Default value is 3600 seconds (1 hour) Smarty's default value
$config['cache_lifetime']       = 3600;

// Where templates are compiled
$config['compile_directory']    = APPPATH."cache/smarty/compiled/";

// Where templates are cached
$config['cache_directory']      = APPPATH."cache/smarty/cached/";

// Where Smarty configs are located
$config['config_directory']     = APPPATH."third_party/Smarty/configs/";

// Default extension of templates if one isn't supplied
$config['template_ext']         = 'tpl';

// Error reporting level to use while processing templates
$config['template_error_reporting'] = E_ALL & ~E_NOTICE;
