<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of version
 *
 * @author alberto
 */
class Version extends Route {
	//put your code here
	
    public $id          = FALSE;
	public $product_id;
	public $name;
	public $code;
	public $published   = FALSE;
	
	public $type_product_id = FALSE;
	
    private $_contents   = array();
    private $_images     = array();
    private $_default_image;
    private $_groups_features = array();
    private $_links = array();
	
	private $_content;
	
    function __construct()
    {
        parent::__construct();
        
        // init empty contents
		if($this->environment == 'admin')
		{
			$this->_init_contents();
		}
    }
    
	public function set_links()
	{
		$this->_links = $this->front_link_model->get_version_links($this);
	}
	
	public function get_links()
	{
		return $this->_links;
	}
	
	
	/**
	 * set empty product content translations list
	 * 
	 * @access private
	 */
    private function _init_contents()
    {
        foreach($this->languages as $lang)
        {
            $content = new Version_content();
            $content->iso = $lang->iso;

            $this->_contents[$lang->iso] = $content;
        }
    }
    
	public function set_content()
	{
		$this->_content = $this->front_version_model->get_content($this->id);
		//$this->set_route();
	}
	
	private function _set_content()
	{
		if(is_null($this->_content))
		{
			$this->_content = $this->front_version_model->get_content($this->id);
		}
	}
	
	
	public function get_content($field)
	{
		$this->_set_content();
		
		return $this->_content->$field;
	}


	
	/**
	 * product publication test
	 * 
	 * @access public
	 * @return bool
	 */	
    public function is_published()
    {
        return (bool) $this->published;
    }
    
	/**
	 * set product content translations list
	 * 
	 * @access public
	 * @param array $contents
	 */
    public function set_contents($contents)
    {
        $this->_contents = $contents;
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
    
	/**
	 * set product image list
	 * 
	 * @access public
	 * @param array $images
	 */
    public function set_images($images = NULL)
    {
		if(is_array($images))
		{
			$this->_images = $images;
		}
		else 
		{
			$this->_images = $this->front_version_model->get_images($this->id);
		}
    }
    
	/**
	 * get product image list
	 * 
	 * @access public
	 * @return array
	 */
    public function get_images($type = NULL)
    {
		if($type) // frontend
		{
			return (isset($this->_images[$type])) ? $this->_images[$type] : array();
		}
		
		// backend 
		return $this->_images;
    }
    
	/**
	 * Check if $image_id is the default image id
	 * 
	 * @access public
	 * @param int $image_id
	 * @return bool
	 */
    public function is_default_image($image_id)
    {
        return ($this->default_image_id == $image_id);
    }
    
	/**
	 * set default image for product
	 * 
	 * @param Image $image
	 */
    public function set_default_image($image = NULL)
    {
		if($image)
		{
			$this->_default_image = $image;
		}
		else
		{
			$this->_default_image = $this->front_image_model->get($this->default_image_id);
		}
    }
    
    /**
     * get default image for product
     * 
	 * @access public
     * @return Image
     */
    public function get_default_image()
    {
		if(is_null($this->_default_image))
		{
			$this->set_default_image($this->image_model->get_image($this->default_image_id));
		}
		
        return $this->_default_image;
    }
    
	/**
	 * set product category
	 * 
	 * @access public
	 * @param Category $category
	 */
    public function set_category(Category $category)
    {
        $this->_category = $category;
    }
    
	/**
	 * get product category
	 * 
	 * @access public
	 * @return Category
	 */
    public function get_category()
    {
        return $this->_category;
    }

	/**
	 * format price
	 * 
	 * @return string
	 */
	public function get_price()
	{
		return number_format($this->price, 2 , ',' , '.');
	}
    
    public function set_groups_features($groups_features)
    {
        $this->_groups_features = $groups_features;
    }    
    
    public function get_groups_features()
    {
        return $this->_groups_features;
    }
	
	
	public function set_features()
	{
		$this->_groups_features = $this->front_version_model->get_version_features($this->product_id, $this->id, $this->type_product_id);
	}
	
}

?>
