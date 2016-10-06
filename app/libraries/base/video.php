<?php

/**
 * Description of video
 *
 * @author Alberto
 */
class Video extends Library_model {
	public $id;
	public $name;
	public $url;
	public $channel			= 'youtube';
	public $published		= FALSE;
	public $partner_id;
	
	protected $_contents_class	= 'Video_content';
	protected $_model			= 'video_model';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function get_channels()
	{
		return array('youtube' => 'YouTube', 'vimeo' => 'Vimeo');
	}
	
	
	public function is_default($product_id = NULL)
	{
		if($product_id)
		{
			return (bool) $this->db->get_where('product_videos', array('video_id' => $this->id, 'product_id' => $product_id, 'is_default' => 1))->row();
		}
		
		return FALSE;
	}
	
	public function get_partner()
	{
		if($this->partner_id)
		{
			return $this->db->get_where('partners', array('id' => $this->partner_id))->row(0, 'partner');
		}
		
		return new Partner('BorghInTour');
	}
	
}

?>
