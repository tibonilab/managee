<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of version_content
 *
 * @author alberto
 */
class Version_content {
	public $version_id = FALSE;
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
