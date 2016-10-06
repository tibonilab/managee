<?php
/**
 * Description of front_page_model
 *
 * @author Alberto
 */
class Front_video_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function get_all()
	{
		$this->db->order_by('ord');
		$this->db->where('published', 1);
		return $this->db->get('videos')->result('video');
	}
	
	public function get_item_contents($item_id)
	{
		return $this->db->get_where('video_contents', array('video_id' => $item_id, 'iso' => $this->iso))->row(0, 'video_content');
	}
	
	public function get($id)
	{
		return $this->db->get_where('videos', array('id' => $id))->row(0, 'video');
	}
	
	
	public function get_latests($limit)
	{
		$this->db->where('published', 1);
		$this->db->order_by('ord');
		$this->db->limit($limit);
		return $this->db->get('videos')->result('video');
	}
}

?>
