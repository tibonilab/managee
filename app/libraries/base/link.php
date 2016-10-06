<?php

/**
 * Description of type
 *
 * @author alberto
 */
class Link {
    public $id = NULL;
    public $name;
	public $target;
	public $icon;
		
	private $_contents = array();
    private $_is_product_link = FALSE;
	private $_is_version_link = FALSE;
	
	private $_path;
	private $_content;
	
    function __construct()
    {
		if($this->environment == 'admin')
		{
			// init empty contents
			$this->_init_contents();
		}
		
		$this->_set_path();
    }
    
	private function _set_path()
	{
		$this->_path = substr($this->config->item('icons_images_path'), 2);
	}
	
	public function __get($var)
	{
		return get_instance()->$var;
	}
	
	
	/**
	 * set empty product content translations list
	 * 
	 * @access private
	 */
    private function _init_contents()
    {

		// init empty language contents
		foreach($this->languages as $lang)
		{
			$content = new Link_content();
			$content->iso = $lang->iso;

			$this->_contents[$lang->iso] = $content;
		}
    }
    
	/**
	 * set product content translations list
	 * 
	 * @access public
	 * @param array $contents
	 */
    public function set_contents($contents)
    {
		foreach($contents as $content)
		{
			$this->_contents[$content->iso] = $content;
		}
        
	}
	
	/**
	 * get product content tranlations list
	 * 
	 * @access public
	 * @return array
	 */
    public function get_contents()
    {
        return $this->_contents;
    }
	
	
	public function set_is_product_link($value)
	{
		$this->_is_product_link = (bool) $value;
	}
	
	public function is_product_link()
	{
		return (bool) $this->_is_product_link;
	}	
	
	public function set_is_version_link($value)
	{
		$this->_is_version_link = (bool) $value;
	}
	
	public function is_version_link()
	{
		return (bool) $this->_is_version_link;
	}
	
	public function get_icon()
	{
		return $this->_path . $this->icon;
	}
	
    
	
	
	/* Frontend */
	
	public function set_content($entity = NULL)
	{
		$this->_content = $this->front_link_model->get_content($this->id, $entity);
	}

	
	public function get_content($field = NULL)
	{
		return ($field) ? $this->_content->$field : $this->_content;
	}
}

?>
