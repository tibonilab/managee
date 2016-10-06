<?php

if( ! function_exists('home_url'))
{
	function home_url()
	{
		$CI =& get_instance();
		
		if($CI->language->is_default())
			return $CI->config->base_url();
		else
			return site_url();
	}
}


if( ! function_exists('assets_url'))
{
	function assets_url($filename, $type)
	{
		$CI =& get_instance();
		
		switch($type)
		{
			case 'img':
				$type = 'images/layout/';
				break;
			
			case 'css':
				$type = 'css/';
				break;
			
			case 'js':
				$type = 'js/';
				break;
			
			default:
				$type = $type . '/';
		}
		
		return base_url('assets/' . $CI->layout->get_theme() . $type . $filename);
	}
}


if( ! function_exists('media_url'))
{
	function media_url($filename, $type)
	{
		$CI =& get_instance();
		
		$type .= '/';

		return base_url('assets/'.$CI->params->get('frontend_theme').'/images/mediagallery/' . $type . $filename);
	}
}


if( ! function_exists('refresh'))
{
	function refresh()
	{
		redirect($_SERVER['HTTP_REFERER']);
	}
}




function ymd_to_dmy($str)
{
	$var = explode('-', $str);
	return $var[2] . '/' . $var[1] . '/' . $var[0];
}

?>