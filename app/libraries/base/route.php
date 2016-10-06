<?php

class Route
{
	protected $_slug = NULL;
	protected $_category;
	
	
	
	private $_attachments;
	
	function __construct() {
		
	}
	
	public function __get($var)
	{
		return get_instance()->$var;
	}
	
	public function set_route($route_id = NULL)
	{
		$route_id = $route_id ? $route_id : $this->get_content('route_id');
		
		$this->_slug = $this->route_model->get_slug_by_id($route_id);
	}
	
		
	public function get_route()
	{
		if(is_null($this->_slug))
		{
			$this->set_route();
		}
		return base_url($this->_slug);
	}
	
	public function has_default_image()
    {
        return (bool) $this->default_image_id;
    }
	
	public function get_json_data()
	{
		$this->href = url_title($this->get_content('name'), '-', TRUE);
		return htmlentities(json_encode($this));
	}
		
	public function set_category(Category $category)
    {
        $this->_category = $category;
    }
	
	private function _set_category()
	{
		if($this->environment == 'front')
		{
			$this->set_category($this->front_category_model->get($this->category_id));
		}
		else
		{
			$this->set_category($this->category_model->get_category($this->category_id));
		}
	}
	
		
	/**
	 * get product category
	 * 
	 * @access public
	 * @return Category
	 */
    public function get_category()
    {
		if( is_null($this->_category))
		{
			$this->_set_category();
		}
		
        return $this->_category;
    }
	
	
	public function has_category()
	{
		return (bool) $this->category_id;
	}
	
	public function get_attachments()
	{
		$this->_set_attachments();
		
		return $this->_attachments;
	}
	
	
	private function _set_attachments()
	{
		if(is_null($this->_attachments))
		{
			$this->db->join('attachments a', 'a.id = ' .$this->_rel_table. '.attachment_id');
			$this->db->where($this->_rel_table.'.'.$this->_rel_item, $this->id);
			$this->_attachments = $this->db->get($this->_rel_table)->result('attachment');
		}
	}
	
}

?>
