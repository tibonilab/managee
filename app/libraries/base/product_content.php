<?php
/**
 * Product_content - Content data translations for Product
 *
 * @package CodeIgniter
 * @subpackage ecommerce
 * @category products
 * @author Tiboni Alberto - http://www.tibonilab.com/
 */
class Product_content {
    public $page_id = FALSE;
    public $iso;
    public $active  = TRUE;
    
    public $name;
    public $description;
    public $meta_title;
    public $meta_key;
    public $meta_descr;
    
    private $_slug;
    
	/**
	 * product language activation test
	 * 
	 * @access public
	 * @return bool
	 */
    public function is_active()
    {
        return (bool) $this->active;
    }
    
	/**
	 * set product slug for the iso language
	 * 
	 * @access public
	 * @param string $slug
	 */
    public function set_slug($slug)
    {
        $this->_slug = $slug;
    }
    
	/**
	 * get product slug for the iso language
	 * 
	 * @access public
	 * @return string $slug
	 */
    public function get_slug()
    {
        return $this->_slug;
    }
}

?>
