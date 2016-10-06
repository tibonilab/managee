<?php

/**
 * Description of contents
 *
 * @author Alberto
 */
class Contents {
	
	public $route_id = NULL;
	
	private $_slug;
	
	function __construct() {	}
	
	function __get($var)
	{
		return get_instance()->$var;
	}
	
	private function _set_route()
	{
		$this->_slug = ($this->route_id) ? $this->route_model->get_slug_by_id($this->route_id) : NULL;
	}
	
		
	public function get_route()
	{
		if(is_null($this->_slug))
		{
			$this->_set_route();
		}
		return $this->_slug;
	}
	
	public function is_active()
	{
		return (bool) $this->active;
	}
}

?>
