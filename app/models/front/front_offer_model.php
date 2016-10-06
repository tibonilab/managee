<?php
/**
 * Description of front_offer_model
 *
 * @author Alberto
 */
class Front_offer_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function get_homepage()
	{
		$this->db->order_by('ord');
		$list = $this->db->get_where('offers', array('in_homepage' => 1, 'published' => 1))->result('offer');
		
		foreach($list as $item)
		{
			$item->set_content();
		}
		
		return $list;
	}
	
	public function get_content($offer_id)
	{
		$content = $this->db->get_where('offer_contents', array('offer_id' => $offer_id, 'iso' => $this->iso))->row(0, 'offer_content');
		
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
		
		$list = $this->db->get('offers')->result('offer');
		
		foreach($list as $item)
		{
			$item->set_content();
		}
		
		return $list;
	
	}
	
	public function get($id)
	{
		$offer = $this->db->get_where('offers', array('id' => $id))->row(0, 'offer');
		
		if( ! $offer )
			return FALSE;
		
		$offer->set_content();
		
		return $offer;
	}
	
	public function get_images($offer_id)
	{
		$images = $this->db->order_by('ord')
				->join('images', 'images.id = offer_images.image_id')
                ->where('offer_id', $offer_id)
                ->get('offer_images')
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
