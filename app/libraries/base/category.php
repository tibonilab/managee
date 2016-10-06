<?php
/**
 * Description of Category
 *
 * @author Alberto
 */
class Category extends Route {

	public $id = FALSE;
	public $module = 'products';
    public $name;
    public $parent_id;
    public $published = FALSE;
    public $default_image_id = FALSE;	
	
    private $childs		= array();
    private $products	= array();
    private $contents; // translations
	
	private $_images     = array();
	private $_default_image;
	private $_content;
    
	
    function __construct($parent_id = 0, $module = NULL) {
		parent::__construct();
		
        $this->parent_id = $parent_id;
		
		if($module)
		{
			$this->module = $module;
		}
    }
    
    public function set_childs($childs)
    {
        $this->childs = $childs;
    }
	
 	public function has_childs()
	{
		return (bool) $this->get_childs();
	}
	   
    public function get_childs()
    {
        return $this->childs;
    }
    
    public function is_leaf()
    {
        return (count($this->childs) > 0) ? FALSE : TRUE;
    }
    
    public function is_branch()
    {
        return (count($this->childs) > 0) ? TRUE : FALSE;
    }
    
    public function is_root()
    {
        return ($this->parent_id) ? FALSE : TRUE;
    }
    

    
    public function set_products($products)
    {
        $this->products = $products;
    }
    
    public function get_products()
    {
        return $this->products;
    }
    
    public function has_products()
    {
        return (count($this->products) > 0) ? TRUE : FALSE;
    }
    

    
    
    public function is_published()
    {
        return (bool) $this->published;
    }
    
    public function set_contents($contents)
    {
        $this->contents = $contents;
    }
    
    public function get_contents()
    {
        return $this->contents;
    }
	
	
	public function set_content()
	{
		$this->_content = $this->front_category_model->get_content($this->id);
		$this->set_route();
	}
	
	public function get_content($field)
	{
		return $this->_content->$field;
	}
	
	
	
	/* images */
	
	public function set_images($images)
    {
        $this->_images = $images;
    }
    
	/**
	 * get product image list
	 * 
	 * @access public
	 * @return array
	 */
    public function get_images()
    {
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
    public function set_default_image($image)
    {
        $this->_default_image = $image;
    }
    
    /**
     * get default image for product
     * 
	 * @access public
     * @return Image
     */
    public function get_default_image()
    {
        return $this->_default_image;
    }
	
	
}

?>
