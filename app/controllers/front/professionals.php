<?php
/**
 * Description of professionals
 *
 * @author alberto
 */
class Professionals extends Front_controller{
	
	protected $_views_path = 'professionals';
	
	function __construct() {
		parent::__construct();
		$this->load->model(array(
			'front/front_professional_model', 
			'front/front_news_model',
			'front/front_showcase_model'
		));
	}

	public function index()
	{
		
		$this->_view('index');
	}
	
	public function show($id)
	{
		$item = $this->front_professional_model->get($id);
		
		if( ! $item ) 
		{
			redirect(home_url());
		}
		
		$this->set_meta_by($item);
		
		$this->data['breadcrumbs']['first_item'] = array('url' => $item->get_route(), 'label' => $item->get_content('title'));
		
		$this->data['item'] = $item;
		
		$this->_view('show');
	}
	
}

?>
