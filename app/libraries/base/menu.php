<?php

/**
 * Description of menu
 *
 * @author Alberto
 */
class Menu {
	public $id;
	public $name;
	
	private $_items;
	
	function __get($name) {
		return get_instance()->$name;
	}

	private function _set_items()
	{
		if(is_null($this->_items))
		{
			$this->db->order_by('ord');
			$this->db->where('menu_id', $this->id);
			$this->db->where('parent_id', 0);
			$this->_items = $this->db->get('menu_items')->result('menu_item');
		}
	}
	
	public function get_items()
	{
		$this->_set_items();
		
		return $this->_items;
	}
}

?>