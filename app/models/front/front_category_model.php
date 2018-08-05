<?php
/**
 * Description of front_category_model
 *
 * @author Alberto
 */
class Front_category_model extends MY_Model{
	
	function __construct() {
		parent::__construct();
	}
	
	public function get_categories($parent_id = 0, $module = 'products')
	{
		$categories = $this->db->order_by('ord')
							->get_where('categories', array(
									'parent_id' => $parent_id,
									'published'	=> 1,
									'module'	=> $module
							))->result('category');
		
		foreach($categories as $category)
		{
			$this->_set_foreign_data($category);
		}
		
		return $categories;
	}
	
	public function get($id)
	{
		$category = $this->db->get_where('categories', array('id' => $id))->row(0, 'category');
		
		if($category) 
		{
			$this->_set_foreign_data($category, TRUE);
		}
		return $category;
	}
	
	private function _set_foreign_data(Category $category, $products = FALSE)
	{
		$category->set_childs($this->get_categories($category->id, $category->module));
		$category->set_content($this->get_content($category->id));
		$category->set_default_image($this->front_image_model->get($category->default_image_id));
		
		if($products)
		{
			$call = 'get_category_' . $category->module;

			if(method_exists($this, $call))
			{
				$category->set_products($this->$call($category));
			}
		}
	}
	
	private function _get_id_list($category, $categories)
	{
		$list = $this->db->get_where('categories', array('parent_id' => $category->id))->result('category');
		
		foreach($list as $tem)
		{
			$categories[]	= $tem->id;
			$categories		= $this->_get_id_list($tem, $categories);
		}
		
		return $categories;

	}
	
	public function get_category_pages(Category $category)
	{
		$categories = array($category->id);
		$categories = $this->_get_id_list($category, $categories);
		
		$this->db->select('pages.*');
		$this->db->where('published', 1);
		$this->db->where_in('category_id', $categories);
		/**  set order by creation date for blog */
		//$products = $this->db->order_by('ord')->get('pages')->result('page'); 
		$products = $this->db->order_by('created', 'desc')->get('pages')->result('page');
		
		foreach($products as $item)
		{
			$item->set_content();
			
			if(method_exists($item, 'set_default_image'))
			{
				$item->set_default_image($this->front_image_model->get($item->default_image_id));
			}
		}
		
		return $products;
	}
	
	
	public function get_category_products(Category $category)
	{
		$per_page	= 50;
		$module		= $this->input->get('module');
		$lib		= $this->input->get('lib');

		$page		= $this->input->get('page');
		$start		= $per_page * $page;
		
		
		$categories = array($category->id);
		$categories = $this->_get_id_list($category, $categories);
		
		$this->db->select('products.*');
		$this->db->where('published', 1);
		$this->db->where_in('category_id', $categories);
		$this->db->limit($per_page, $start);
		$products = $this->db->order_by('has_map desc, ord')->get('products')->result('product');
		
		foreach($products as $item)
		{
			$item->set_content();
			$item->set_default_image($this->front_image_model->get($item->default_image_id));
		}
		
		return $products;
	}
		
	public function get_content($category_id)
	{
		$content = $this->db->get_where('category_contents', array('category_id' => $category_id, 'iso' => $this->iso))->row(0, 'category_content');

		return $content;
	}
	
	public function get_breadcrumbs($category)
	{
		$breadcrumbs = array($category);
		$breadcrumbs = array_merge($breadcrumbs, $this->get_parent($category));
		
		return array_reverse($breadcrumbs);
			
	}
	
	public function get_parent($category, $breadcrumbs = array())
	{
		
		$parent = $this->db->get_where('categories', array('id' => $category->parent_id))->row(0, 'category');
		
		if($parent)
		{
			$parent->set_content();
		
			if($parent->parent_id) 
			{
				$this->get_parent ($parent, $breadcrumbs);
			}

			$breadcrumbs = array_merge($breadcrumbs, array($parent));
		}
		
		
		return $breadcrumbs;
	}
	
}

?>
