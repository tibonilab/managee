<?php
/**
 * Description of pages
 *
 * @author alberto
 */
class Showcases extends Front_controller {
	
	protected $_views_path = 'showcases';
	
	function __construct() {
		parent::__construct();
		$this->load->model(array('front/front_showcase_model', 'front/front_image_model'));
	}
	
	public function featured($id)
	{
		$list = $this->front_showcase_model->get_showcase_feateured_products($id);
		
		if( ! $list ) 
		{
			redirect(home_url());
		}
		
		$this->data['breadcrumbs']['first_item'] = array('url' => uri_string(), 'label' => 'Portfolio');
		
		$this->data['products'] = $list;
		
		$this->_view('featured');
	}
	
	public function show($id)
	{
		$item = $this->front_showcase_model->get($id);
		
		if( ! $item ) 
		{
			redirect(home_url());
		}
		
		$this->data['breadcrumbs']['first_item'] = array('url' => uri_string(), 'label' => 'Foto');
		
		$this->data['item'] = $item;
		
		$this->_view('show');
	}
	
	
}

?>
