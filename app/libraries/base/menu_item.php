<?php

/**
 * Description of menu_item
 *
 * @author Alberto
 */
class Menu_item {
	
	public $id;
	public $name;
	public $menu_id;
	public $parent_id;
	public $entity;
	public $entity_id;
	public $target;
	public $ord;
	public $icon;
	
	private $_contents;
	private $_childs;
	
	public function __construct($menu_id = FALSE) {
		$this->menu_id = $menu_id;
		
	}
	
	public function __get($name) {
		return get_instance()->$name;
	}
	
	private function _set_childs()
	{
		if(is_null($this->_childs))
		{
			if($this->entity == 'categories' AND $this->environment == 'front')
			{
				$this->db->where('parent_id', $this->entity_id);
				$categories = $this->db->get('categories')->result('category');
				
				foreach($categories as $item)
				{
					// set product content
					$item->set_content();
					
					$child	= new Menu_item();
					$child->_contents = new stdClass();
					$child->_contents->label	= $item->get_content('name');
					$child->_contents->url		= $item->get_route();
					$this->_childs[] = $child;
				}
				
				/*
				$this->db->where('category_id', $this->entity_id);
				$products = $this->db->get('products')->result('product');
				
				foreach($products as $item)
				{
					// set product content
					$item->set_content();
					
					$child	= new Menu_item();
					$child->_contents = new stdClass();
					$child->_contents->label	= $item->get_content('name');
					$child->_contents->url		= $item->get_route();
					$this->_childs[] = $child;
				}
				*/
			}
			else 
			{
				$this->db->where('parent_id', $this->id);
				$this->db->order_by('ord');
				$this->_childs = $this->db->get('menu_items')->result('menu_item');
			}
		}
	}
	
	private function _get_hierarchy($parent_id)
	{
		return $this->db->get_where('menu_items', array(
			'menu_id'	=> $this->menu_id,
			'id'		=> $parent_id
		))->row(0, 'menu_item');
	}
	
	private function _get_recursive_parents($item, $return)
	{
		$return[$item->id] = $item->get_hierarchy();
		
		foreach($item->get_childs() as $child)
		{
			$return = $this->_get_stocazzo($child, $return);
		}
		
		return $return;
	}
	
	private function _set_contents()
	{
		if(is_null($this->_contents))
		{
			if($this->environment == 'front')
			{
				$this->db->where('iso', $this->iso);
				$this->db->where('menu_item_id', $this->id);
				$this->_contents = $this->db->get('menu_item_contents')->row();
			}
			else
			{
				$this->db->where('menu_item_id', $this->id);
				$contents = $this->db->get('menu_item_contents')->result();
				
				foreach($contents as $content)
				{
					$this->_contents[$content->iso] = $content;
				}
			}
		}
	}
	
	public function get($field, $iso = NULL)
	{
		$this->_set_contents();
		
		if($iso)
		{
			return (isset($this->_contents[$iso]->$field)) ? $this->_contents[$iso]->$field : NULL;
		}
		
		return isset($this->_contents->$field) ? $this->_contents->$field : NULL;
	}
	
	public function get_childs()
	{
		$this->_set_childs();
		
		return $this->_childs;
	}
	
	public function get_hierarchy()
	{
		$hierarchy = array($this->name);
		$parent_id = $this->parent_id;
		while($res = $this->_get_hierarchy($parent_id))
		{
			$hierarchy[]	= $res->name;
			$parent_id	= $res->parent_id;
		}
		
		return '/' . implode('/', array_reverse($hierarchy));
	}
	
	public function get_icon()
	{
		return base_url('assets/'.$this->params->get('frontend_theme') . '/images/menu_items/' . $this->icon);
	}
	
	public function get_parent_menu_item_list()
	{
		$return = array('/');
		
		if($this->menu_id)
		{
			if($this->id)
			{
				$this->db->where('id !=', $this->id);
			}
			$this->db->order_by('ord, parent_id');
			$this->db->where('menu_id', $this->menu_id);
			$this->db->where('parent_id', 0);
			$list = $this->db->get('menu_items')->result('menu_item');
			
			foreach($list as $item)
			{
				$return = $this->_get_recursive_parents($item, $return);
			}
		}
		
		return $return;
	}
	
	public function get_url($iso = NULL)
	{
		$url = '';
		
		// get URL or generate it by linked entity
		switch($this->entity)
		{
			default:
				$url = base_url($this->get('url', $iso));
				break;

			case 'pages':
				$this->load->model('front/front_page_model');
				$url = $this->front_page_model->get($this->entity_id)->get_route();
				break;
			
			case 'news':
				$this->load->model('front/front_news_model');
				$url = $this->front_news_model->get_news_by_id($this->entity_id)->get_route();
				break;			
			
			case 'showcases':
				$this->load->model('front/front_showcase_model');
				$url = $this->front_showcase_model->get($this->entity_id)->get_route();
				break;
			
			case 'categories':
				$this->load->model('front/front_category_model');
				$url = $this->front_category_model->get($this->entity_id)->get_route();
				break;
		}
		
		// if $iso is setted the invoker is in admin environment, so return URL only
		// otherwise invoker is in front environment, so return URL and #hash appended too
		return ($iso) ? $url : $url . $this->get('hash');
	}
	
	public function has_childs()
	{
		$this->_set_childs();
		
		return (bool) count($this->_childs);
	}
	
}
