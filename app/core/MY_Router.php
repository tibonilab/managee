<?php
require_once( BASEPATH .'database/DB'. EXT );

/**
 * Description of MY_Router
 *
 * @author Alberto
 */
class MY_Router extends CI_Router{
	
	function __construct() {
		parent::__construct();
	}
	
	function _validate_request($segments) 
	{
		// search for current slug in database routes
		$db_slug = $this->_get_db_slug($this->_get_url());
		
		// do redirect if setted in db slug
		$this->_redirect($db_slug);
		
		// if a slug matched pass the route to the CI router
		if($db_slug) $segments = explode('/', $db_slug->route);
				
		return parent::_validate_request($segments);
	}
	
	protected function _is_one_language() 
	{
		$db =& DB();
		return ($db->where('active', 1)->from('languages')->count_all_results() > 1) ? FALSE : TRUE;
	}
	
	protected function _get_url()
	{
		$segments_array = $this->uri->segment_array();
		$my_segments	= array();
		
		for($n=0; $n<$this->uri->total_segments();$n++)
		{
			$my_segments[] = $segments_array[$n];
		}

		return implode('/', $my_segments);
	}
	
	protected function _get_db_slug($slug) {
		$db =& DB();
		$db->where('slug', $slug);
		return $db->get('routes')->row();
	}
	
	protected function _redirect($route)
	{
		if ( ! empty($route->redirect)) 
		{
			header('Location: ' . $route->redirect, FALSE, $route->response_code);
			exit();
		}
	}
}

?>
