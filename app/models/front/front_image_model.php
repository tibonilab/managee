<?php

/**
 * Description of front_image_model
 *
 * @author Alberto
 */
class Front_image_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	/*public function get_content($image_id)
	{
		$this->db->where('iso', $this->iso);
		$this->db->where('image_id', $image_id);

		return $this->db->get('image_contents')->row(0, 'image_content');
	}*/
	
	public function get_item_contents($image_id)
	{
		$this->db->where('iso', $this->iso);
		$this->db->where('image_id', $image_id);

		return $this->db->get('image_contents')->row(0, 'image_content');
	}
	
	
	public function get($id)
	{
		$this->db->where('id', $id);
		$image = $this->db->get('images')->row(0, 'image');
        
        return is_object($image) ? $image : new Image();
	}
	
	
}

?>
