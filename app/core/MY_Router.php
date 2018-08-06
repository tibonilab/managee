<?php
require_once( BASEPATH .'database/DB'. EXT );

/**
 * Description of MY_Router
 *
 * @author Alberto
 */
class MY_Router extends CI_Router{
	
	public $db_driver;
    public $db;

	function __construct() {
		
		// we want to use mysqli when available
        $this->db_driver = function_exists('mysqli_connect') ? 'mysqli' : 'mysql';
		
        // init db connection
		$this->db =& DB($this->_grab_db_config());

		parent::__construct();
	}
	
    private function _is_installed() {
		
		if ( $this->db->conn_id !== FALSE) {
			
			if ($this->db->table_exists('configs')) {
				$is_installed = $this->db->where('key', 'is_installed')
				->get('configs')
				->row();
				
				return $is_installed && (bool) $is_installed->value;
				
			}
			
			return FALSE;
			
		}
		
		return FALSE;
    }
    
    private function _grab_db_config() {
		include(APPPATH . 'config/database.php');

		return [
			'hostname' => $db['default']['hostname'],
			'database' => $db['default']['database'],
			'username' => $db['default']['username'],
			'password' => $db['default']['password'],
			'dbdriver' => $this->db_driver
		];
	}

	function _validate_request($segments) 
	{
		if( $this->_is_installed()) { 
			// search for current slug in database routes
			$db_slug = $this->_get_db_slug($this->_get_url());
			
			// do redirect if setted in db slug
			$this->_redirect($db_slug);
			
			// if a slug matched pass the route to the CI router
			if($db_slug) $segments = explode('/', $db_slug->route);
		}

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
