<?php
/**
 * Description of Library_model
 *
 * @author Alberto
 */
class Library_model  {
	protected $id = NULL;
	
	protected $_model;
	protected $_contents_class;

	protected $_contents		= NULL;
	
	private $_slug	= NULL;
	
	function __construct() 
	{
		$this->_model = ($this->environment == 'admin') ? $this->_model : 'front_' . $this->_model;
	}
	
	function __get($var)
	{
		return get_instance()->$var;
	}
	
	protected function _init_contents()
	{
		$contents = array();
		foreach($this->languages as $lang)
		{
			$contents[$lang->iso] = new $this->_contents_class();
		}
		return $contents;
	}
	
	
	function is_published()
	{
		return (bool) $this->published;
	}
	
	private function _set_contents()
	{
		$this->_contents = (is_null($this->id)) ? $this->_init_contents() : $this->{$this->_model}->get_item_contents($this->id);
	}
	
	public function get_contents($iso = NULL)
	{
		if(is_null($this->_contents))
		{
			$this->_set_contents();
		}
		return ($iso) ? $this->_contents[$iso] : $this->_contents;
	}
	
	public function get_content($field, $trim_at = NULL)
	{
		if(is_null($this->_contents))
		{
			$this->_set_contents();
		}
		
		if($trim_at)
		{
			if (isset($this->_contents->$field))
			{
				$suffix = (strlen($this->_contents->$field) > $trim_at) ? ' ...' : '';
				return substr($this->_contents->$field, 0, $trim_at) . $suffix; 
			}
			return NULL;
		}
		
		return (isset($this->_contents->$field)) ? $this->_contents->$field : NULL;
	}
	
	private function _set_route()
	{
		$this->_slug = $this->route_model->get_slug_by_id($this->get_content('route_id'));
	}
	
		
	public function get_route()
	{
		if(is_null($this->_slug))
		{
			$this->_set_route();
		}
		
		return base_url($this->_slug);
	}
	
}

?>