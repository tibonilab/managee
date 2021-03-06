<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of products
 *
 * @author alberto
 */
class Products extends Front_controller {
	
	protected $_views_path = 'products';
	
	
	function __construct() {
		parent::__construct();
		$this->load->model(array('front/front_version_model', 'front/front_property_model', 'front/front_group_features_model', 'front/front_product_model', 'front/front_image_model', 'front/front_feature_model', 'front/front_link_model'));
		$this->load->model(array('front/front_category_model', 'front/front_page_model', 'front/front_news_model', 'front/front_showcase_model', 'front/front_image_model'));
		
		//$this->data['breadcrumbs']['first_item'] = array('url' => site_url('photo'), 'label' => 'Photo');
	}
	
	public function index()
	{
		$categories = $this->front_category_model->get_categories();
		
		$this->data['categories']	= $categories;
		
		$this->_view('index');
	}
	
	public function show($id, $view = TRUE)
	{
		$item = $this->front_product_model->get($id);
		
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
		$this->data['breadcrumbs']['list'] = $this->front_category_model->get_breadcrumbs($this->front_category_model->get($item->category_id));
		//$this->data['breadcrumbs']['list'][] = $item;
		
		$this->data['versions_list'] = $this->front_version_model->get_product_versions_as_list($item);
		
		if($view) $this->_view('item');
	}
	
	public function bom($id)
	{		
		$this->layout_view = 'front/layouts/pdf';
		
		$this->load->library('pdf');
		
		// setting data for the view
		$this->show($id, FALSE);
		
		//$this->layout->view('front/pdf/product');
		
        $this->pdf->load_view('front/pdf/product', $this->data);
        $this->pdf->render();
        
        $filename = $this->data['item']->get_content('name') . '_' . date('Y-m-d_H.i.s').'.pdf';
		
		// embed
		/*$pdf_content = $this->pdf->output();
        file_put_contents('./assets/front/pdf/'. $filename, $pdf_content);
        redirect('/assets/front/pdf/'. $filename);  
		 * 
		 */
		
		// download
		$this->pdf->stream($filename);
	}
	
}

?>
