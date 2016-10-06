<?php
/**
 * Description of video
 *
 * @author Alberto
 */
class Videos extends Front_controller {
	
	protected $_views_path = 'videos';
	
	public function __construct() {
		parent::__construct();
		$this->load->model('front/front_video_model');
		
		$this->data['breadcrumbs']['first_item'] = array('url' => site_url('video'), 'label' => 'Video');
	}
	
	public function index()
	{
		$this->data['video_list'] = $this->front_video_model->get_all();
		
		$this->_view('index');
		
	}
	
	
	public function show($id)
	{
		$item = $this->front_video_model->get($id);
		
		if( ! $item )
		{
			show_404();
		}
		
		if( ! $item->is_published() )
		{
			redirect(base_url(), 'location', 302);
		}
		
		$this->set_meta_by($item);
		
		$this->data['item'] = $item;
		
		$this->_view('single');
	}
	
	
	
	
	
}

?>
