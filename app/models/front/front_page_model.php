<?php
/**
 * Description of front_page_model
 *
 * @author Alberto
 */
class Front_page_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function get_homepage()
	{
		$page = $this->db->get_where('pages', array('is_homepage' => 1))->row(0, 'page');
		
		if( ! $page )
			return FALSE;
		
		$page->set_content();
		
		return $page;
	}
	
	public function get_all($filter = NULL)
	{
        if($filter AND is_array($filter))
        {
            foreach($filter as $field => $value)
            {
                $this->db->where($field, $value);
            }
        }
        
		return $this->db->get_where('pages', array('published' => 1))->result('page');
	}
	
	public function get_content($page_id)
	{
		$content = $this->db->get_where('page_contents', array('page_id' => $page_id, 'iso' => $this->iso))->row(0, 'page_content');
		
		//$this->_parse_content($content);
		
		return $content;
	}
	
	public function get($id)
	{
		$page = $this->db->get_where('pages', array('id' => $id))->row(0, 'page');
		
		if( ! $page )
			return FALSE;
		
		$page->set_content();
		
		return $page;
	}
	
	public function get_images($page_id)
	{
		$images = $this->db->order_by('ord')
				->join('images', 'images.id = page_images.image_id')
                ->where('page_id', $page_id)
                ->get('page_images')
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
