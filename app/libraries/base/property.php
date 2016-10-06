<?php

/**
 * Description of type
 *
 * @author alberto
 */
class Property {
    public $id = NULL;
    public $name;
	public $icon;
	
	private $_contents = array();
    private $_is_product_property = FALSE;
	
    private $_CI;
    
	private $_path;
	private $_content;
	
    function __construct()
    {
        $this->_CI =& get_instance();
        
		if($this->_CI->environment == 'admin')
		{
			// init empty contents
			$this->_init_contents();
		}
		$this->_set_path();
    }
    
	private function _set_path()
	{
		$this->_path = substr($this->_CI->config->item('icons_images_path'), 2);
	}
	
	/**
	 * set empty product content translations list
	 * 
	 * @access private
	 */
    private function _init_contents()
    {

		// init empty language contents
		foreach($this->_CI->languages as $lang)
		{
			$content = new Property_content();
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
	
	
	public function set_is_product_property($value)
	{
		$this->_is_product_property = (bool) $value;
	}
	
	public function is_product_property()
	{
		return (bool) $this->_is_product_property;
	}
	
	public function get_icon()
	{
		return $this->_path . $this->icon;
	}
	
    
	
	
	/* Frontend */
	
	public function set_content()
	{
		$this->_content = $this->_CI->front_property_model->get_content($this->id);
	}

	
	public function get_content($field)
	{
		return $this->_content->$field;
	}
}

?>
