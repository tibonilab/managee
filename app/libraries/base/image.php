<?php
/**
 * Image Class
 *
 * @package CodeIgniter
 * @subpackage ecommerce
 * @category images
 * @author Tiboni Alberto - http://www.tibonilab.com/
 */

class Image extends Library_model {
    public $id;
    public $src;
    public $name;
    
    //private $_contents;
    private $_path;
    //private $_CI;
    
	//public $_content;
	private $_type	= NULL;
	
	
	protected $_model = 'image_model';
	protected $_contents_class = 'Image_content';
	
	
	public function __construct($set_path = TRUE) {
		parent::__construct();
		
		$this->src = ($this->environment == 'admin') ? assets_url('no-image.png', 'images') : assets_url('logo.png', 'img');
		
		if($set_path)	{
			// set image path
			$this->_set_path();
		}
	}
	
	public function set_type($type)
	{
		$this->_type = $type;
	}

	/*private function _set_type()
	{
		$this->_type = $this->{$this->_model}->;
	}*/

	
	public function get_type()
	{
		/*if(is_null($this->_type))
		{
			$this->_set_type();
		}*/
		return $this->_type;
	}
	
        
    /**
     * set images path from configurations file
     */
    private function _set_path()
    {
        $this->_path = substr($this->config->item('images_images_path'), 2);
    }


/*
| -------------------------------------------------------------------
|  Utils for the view
| -------------------------------------------------------------------
*/
    
    /**
     * get $size format src for <img> tag
     * 
     * @return string
     */
    public function get($size)
    {
        return $this->_path ? $this->_path. $size . '/'. $this->src : $this->src;
    }
        
    /**
     * get thumb format src for <img> tag
     * 
     * @return string
     */
    public function get_thumb()
    {
        return $this->get('thumbs');
    }
    
    /**
     * get big format src for <img> tag
     * 
     * @return string
     */
    public function get_big()
    {
        return $this->get('big');
    }
    
    /**
     * get big medium src for <img> tag
     * 
     * @return string
     */
    public function get_medium()
    {
        return $this->get('medium');
    }
    
    /**
     * get big small src for <img> tag
     * 
     * @return string
     */
    public function get_small()
    {
        return $this->get('small');
    }
        
    /**
     * get big squared src for <img> tag
     * 
     * @return string
     */    
    public function get_squared()
    {
		return $this->get('squared');
    }
	
	public function get_showcase()
	{
		return $this->get('showcase');
	}
	
	public function get_upload()
	{
		return $this->get('upload');
	}
    
}

?>
