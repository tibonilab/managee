<?php

/**
 * Description of menu_model
 *
 * @author Alberto
 */
class Menu_model extends MY_Model{
	
	private $_class = 'menu';
	
	public function __construct() {
		parent::__construct();
	}
	
	private function _save_item_contents($menu_item_id, $method = '_insert')
	{
		$contents = $this->input->post('contents');
		
		foreach($contents as $iso => $content_data)
		{
			$method .= '_item_contents';

			$this->$method($menu_item_id, $iso, $content_data);
		}
	}
	
	private function _insert_item_contents($menu_item_id, $iso, $content_data)
	{
		$content_data += array(
			'menu_item_id'	=> $menu_item_id,
			'iso'			=> $iso
		);

		$this->db->insert('menu_item_contents', $content_data);
	}
	
	private function _update_item_contents($menu_item_id, $iso, $content_data)
	{
		$this->db->where('menu_item_id', $menu_item_id);
		$this->db->where('iso', $iso);
		$this->db->update('menu_item_contents', $content_data);
	}
	
		

	private function _save_items($menu_id)
	{
		$list = $this->input->post('items');
		
		if($list)
		{	
			foreach($list as $menu_item_id => $item_data)
			{
				$item_data	+= array(
					'menu_id'	=> $menu_id
				);
				
				$this->db->where('id', $menu_item_id);
				$this->db->update('menu_items', $item_data);
			}

		}
	}
	
	public function delete_menu_item(Menu_item $menu_item)
	{
		$this->delete_menu_item_image($menu_item);
		
		$this->db->delete('menu_items', array('id' => $menu_item->id));
	}
	
	public function delete_menu_item_image(Menu_item $menu_item, $update = FALSE)
	{
		$old_icon = './assets/'.$this->params->get('frontend_theme') . '/images/menu_items/' . $menu_item->icon;
		
		if(file_exists($old_icon) AND $menu_item->icon)
		{
			unlink($old_icon);
		}
		
		if($update)
		{
			$this->db->where('id', $menu_item->id);
			$this->db->update('menu_items', array('icon' => NULL));
		}
	}
	
	public function delete($id)
	{
		$item = $this->get($id);
		
		foreach($item->get_items() as $menu_item)
		{
			$this->delete_menu_item($menu_item);
		}
		
		$this->db->delete('menus', array('id' => $id));
	}
	
	public function get_all()
	{
		return $this->db->get('menus')->result($this->_class);
	}
	
	public function get($id)
	{
		$this->db->where('id', $id);
		$item = $this->db->get('menus')->row(0, $this->_class);
		
		return ( $item ) ? $item : new Menu();
	}
	
	public function get_menu_item($menu_id = FALSE, $menu_item_id = FALSE)
	{
		$this->db->where('id', $menu_item_id);
		$item = $this->db->get('menu_items')->row(0, 'menu_item');
		
		return ( $item ) ? $item : new Menu_item($menu_id);
	}
	
	public function init_menu_item_validation_rules($menu_item_id)
	{
		$rules = array(
			array(
				'field' => 'item[name]',
				'label' => 'Nome voce di menù',
				'rules' => ($menu_item_id) ? 'trim|required|is_unique[menu_items.name.id.'.$menu_item_id.']' : 'trim|required|is_unique[menu_items.name]'
			),
			array(
				'field' => 'item[parent_id]',
				'label' => '',
				'rules' => ''
			),
			array(
				'field' => 'item[entity]',
				'label' => '',
				'rules' => ''
			),
			array(
				'field' => 'item[entity_id]',
				'label' => '',
				'rules' => ''
			),
			array(
				'field' => 'item[target]',
				'label' => '',
				'rules' => ''
			)
		);
				
		return $rules;
	}
	
	public function init_validation_rules($id)
	{
		$rules = array(
			array(
				'field' => 'item[name]',
				'label' => 'Nome menu',
				'rules' => ($id) ? 'trim|required|is_unique[menus.name.id.'.$id.']' : 'trim|required|is_unique[menus.name]'
			),
		);
		
		return $rules;
	}
	
	
	public function save($id = FALSE)
	{
		if ( ! $id)
		{
			$this->db->insert('menus', $this->input->post('item'));
			$id = $this->db->insert_id();
		}
		else
		{
			$this->db->where('id', $id);
			$this->db->update('menus', $this->input->post('item'));
		}
		
		$this->_save_items($id);
		
		return $id;
	}
	
	
	public function save_menu_item($menu_item_id = FALSE, $icon = FALSE)
	{
		$item_data = $this->input->post('item');
		
		if($icon)
		{
			$item_data['icon'] = $icon;
		}
		
		if( ! $menu_item_id)
		{
			$this->db->insert('menu_items', $item_data);
			$menu_item_id = $this->db->insert_id();
			
			$this->_save_item_contents($menu_item_id, '_insert');
		}
		else
		{
			$this->db->where('id', $menu_item_id);
			$this->db->update('menu_items', $item_data);
			
			$this->_save_item_contents($menu_item_id, '_update');
		}
		
		return $menu_item_id;
	}
	
	
	public function sort($list)
    {
        // recursive data extraction
        $data  = $this->_extract($list, 0);
		
		foreach($data as $item_data)
        {
            $this->db->where('id', $item_data['id']);
            $this->db->update('menu_items', $item_data);
        }
    }
    
    /**
     * recursive data extract from nested sortable hierarchy data
     * 
     * @param array $items
     * @param int $parent_id
     * @return array
     */
    private function _extract($items, $parent_id)
    {
        $data = array();
        
        foreach($items as $ord => $item)
        {
            // dump array data
            $data[] = array(
                'id'        => $item['id'],
                'parent_id' => $parent_id,
                'ord'       => $ord
            );
            
            // recursive for childrends
            if(isset($item['children']))
            {
                $childrens  = $this->_extract($item['children'], $item['id']);
                $data       = array_merge($data, $childrens);
            }
        }
        return $data;
        
    }
}
