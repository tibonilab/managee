<?php
/**
 * Description of front_professional_model
 *
 * @author Alberto
 */
class Front_professional_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function get_homeprofessional()
	{
		$this->db->order_by('ord');
		
		$professional = $this->db->get_where('professionals', array('is_homeprofessional' => 1))->row(0, 'professional');
		
		if( ! $professional )
			return FALSE;
		
		$professional->set_content();
		
		return $professional;
	}
	
	public function get_content($professional_id)
	{
		$content = $this->db->get_where('professional_contents', array('professional_id' => $professional_id, 'iso' => $this->iso))->row(0, 'professional_content');
		
		$this->_parse_content($content);
		
		return $content;
	}
	
	public function get_all($discard_id = FALSE)
	{
		$this->db->order_by('ord');
		
		if($discard_id)
		{
			$this->db->where('id !=', $discard_id);
		}
		
		$list = $this->db->get('professionals')->result('professional');
		
		foreach($list as $item)
		{
			$item->set_content();
		}
		
		return $list;
	
	}
	
	public function get($id)
	{
		$professional = $this->db->get_where('professionals', array('id' => $id))->row(0, 'professional');
		
		if( ! $professional )
			return FALSE;
		
		$professional->set_content();
		
		return $professional;
	}
	
	public function get_images($professional_id)
	{
		$images = $this->db->order_by('ord')
				->join('images', 'images.id = professional_images.image_id')
                ->where('professional_id', $professional_id)
                ->get('professional_images')
				->result('image');
        
		$return = array();
        foreach($images as $image)
        {
			//$image->set_content();
			$return[$image->type][] = $image;
        }
        return $return;
	}
	
	private function _parse_content($content)
	{
		$to_replace = array(
			'[SHOWCASE_LIST]',
			'[OFFERS_LIST]'
		);
		
		$replace_with = array(
			$this->layout->widget('showcase/list'),
			$this->layout->widget('offers/list'),
		);
		
		$content->content = str_replace($to_replace, $replace_with, $content->content);
	}
	
}

?>
