<?php


/**
 * Description of front_text_model
 *
 * @author Alberto
 */
class Front_text_model extends Front_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	private function _append_query_is_active()
	{
		$this->db->join('text_contents tc', 'tc.text_id = t.id');
		$this->db->where('tc.iso', $this->iso);
		$this->db->where('tc.active', 1);
	}
	
	public function get_all()
	{
		$this->_append_query_is_active();
		$list = $this->db->get('texts t')->result('text');
		
		$list_array = array();
		foreach($list as $item)
		{
			$item->set_content();
			$list_array[$item->key] = $item->get_content('value');
		}
		
		return $list_array;
	}
	
	public function get_content($text_id)
	{
		$content = $this->db->get_where('text_contents', array('text_id' => $text_id, 'iso' => $this->iso))->row(0, 'text_content');

		return $content;
	}
	
	public function get($id)
	{
		$this->_append_query_is_active();
		$text = $this->db->get_where('texts t', array('t.id' => $id))->row(0, 'text');
		
		if( ! $text)
			return FALSE;
		
		$text->set_content();
		
		return $text;
	}
	
	
}

?>
