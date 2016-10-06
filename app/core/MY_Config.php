<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// CodeIgniter i18n library by Jérôme Jaglale
// http://maestric.com/en/doc/php/codeigniter_i18n
// version 10 - May 10, 2012

class MY_Config extends CI_Config {

	private $_frontend_theme;
	private $_CI;
	
	function __construct() {
		parent::__construct();
	}
	
	function site_url($uri = '')
	{	
		if (is_array($uri))
		{
			$uri = implode('/', $uri);
		}
		
		if (class_exists('CI_Controller'))
		{
			$CI =& get_instance();
			$uri = $CI->lang->localized($uri);			
		}

		return parent::site_url($uri);
	}
	
	function item($item, $index = '')
	{
		return $this->_sanitize_config_item($item, $index);
	}
	
	private function _sanitize_config_item($item, $index)
	{
		// get requested config item
		$config_item = parent::item($item, $index);		
		
		// images array to put dynamic frontend theme
		$images = array('images_images_path', 'images_upload_path');
				
		// put frontend theme in every path(s)
		if( in_array($item, $images) )
		{
			$config_item = str_replace('<MY_THEME_NAME>', get_instance()->params->get('frontend_theme'), $config_item);
		}
		
		// put frontend theme in library config path(s)
		if( $item == 'images_upload_library_config')
		{
			$config_item['images_upload_library_config'] = str_replace('<MY_THEME_NAME>', get_instance()->params->get('frontend_theme'), $config_item);
		}
		
		
		return $config_item;
	}
		
}

/* End of file */
