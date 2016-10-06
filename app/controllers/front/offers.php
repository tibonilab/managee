<?php
/**
 * Description of offers
 *
 * @author alberto
 */
class Offers extends Front_controller{
	
	protected $_views_path = 'offers';
	
	function __construct() {
		parent::__construct();
		$this->load->model(array('offer_model',
			'front/front_offer_model', 
			'front/front_news_model',
			'front/front_showcase_model'
		));
	}

		
	public function index()
	{
		$this->data['offer_list'] = $this->front_offer_model->get_all();
		
		
		$this->_view('index');
	}
	
	
	public function show($id)
	{
		$item = $this->front_offer_model->get($id);
		
		if( ! $item ) 
		{
			redirect(home_url());
		}
		
		$this->set_meta_by($item);
		
		$this->data['breadcrumbs']['first_item'] = array('url' => $item->get_route(), 'label' => $item->get_content('title'));
		
		$this->data['item'] = $item;
		
		if($this->input->is_ajax_request())
		{
			echo $this->layout->snippet('offers/ajax-content', array('item' => $item));
		} 
		else 
		{
			$this->_view('show');
		}
		
	}
	
}

?>
