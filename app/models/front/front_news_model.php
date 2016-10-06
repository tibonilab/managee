<?php
/**
 * Description of front_news_model
 *
 * @author Alberto
 */
class Front_news_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function get_last_news($limit)
	{
		$list = $this->db->order_by('date')
						->limit($limit)
						->where('published', 1)
						->get('news')
						->result('news_lib');
		
		foreach($list as $news)
        {
            $news->set_content();
        }
		
		return $list;
	}
	
	public function get_news_by_id($id)
	{
		$news = $this->db->get_where('news', array('id' => $id))->row(0, 'news_lib');
		
		if( ! $news)
			return FALSE;
		
		$news->set_content();
		
		return $news;
	}
	
	public function get_content($news_id)
	{
		$content = $this->db->get_where('news_contents', array('news_id' => $news_id, 'iso' => $this->iso))->row(0, 'news_lib_content');

		return $content;
	}
	
	
	public function get_all()
	{
		// TODO ORDER BY DATE
		$list = $this->db->order_by('date', 'desc')->get('news')->result('news_lib');
		
		foreach($list as $item)
		{
			$item->set_content();
		}
		
		return $list;
	}
	
	public function get_images($news_id)
	{
		$images = $this->db->order_by('ord')
				->join('images', 'images.id = news_images.image_id')
                ->where('news_id', $news_id)
                ->get('news_images')
				->result('image');
        
		$return = array();
        foreach($images as $image)
        {
			//$image->set_content();
			$return[$image->type][] = $image;
        }
        return $return;
	}
	
}

?>
