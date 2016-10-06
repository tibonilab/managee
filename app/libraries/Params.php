<?php

/**
 * Description of Params
 *
 * @author Alberto
 */
class Params {

	private $_params;
	
	function __construct() {
		$this->_init_params();
	}
	
	public function __get($var)
	{
		return get_instance()->$var;
	}
	
	private function _init_params()
	{
		$configs = $this->db->get('configs')->result();
		
		foreach($configs as $config)
		{
			$this->_params[$config->key] = $config->value;
		}
	}
	
	public function get($key)
	{
		return (isset($this->_params[$key])) ? $this->_params[$key] : NULL;
	}
	
	public function on_maintenance()
	{
		return (isset($this->_params['maintenance'])) ? (bool) $this->_params['maintenance'] : TRUE;
	}
	
	public function maintenance_access_ip()
	{
		return explode(',', str_replace(' ', '', $this->get('maintenance_access_ip')));
	}
}

?>
