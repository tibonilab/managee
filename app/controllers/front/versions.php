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
class Versions extends Front_controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model(array('front/front_version_model', 'front/front_property_model', 'front/front_group_features_model', 'front/front_product_model', 'front/front_image_model', 'front/front_feature_model'));
		$this->load->model(array('front/front_category_model', 'front/front_page_model', 'front/front_news_model', 'front/front_showcase_model', 'front/front_image_model', 'front/front_link_model'));
	}
	
	public function index()
	{
		$categories = $this->front_category_model->get_categories();
		
		$this->data['categories']	= $categories;
		
		
		$this->layout->view('front/products/index');
	}
		
	
	public function show($id, $view = TRUE)
	{
		$version = $this->front_version_model->get($id);
		$product = $this->front_product_model->get($version->product_id);
		
		if( ! $version )
		{
			redirect($product->get_route(), 'location', 301);
		}
		
		$this->set_meta_by($version);
		
		$this->data['version']			= $version;
		$this->data['product']			= $product;
		$this->data['breadcrumbs']		= $this->front_category_model->get_breadcrumbs($this->front_category_model->get($product->category_id));
		$this->data['breadcrumbs'][]	= $product;
		$this->data['breadcrumbs'][]	= $version;
		
		$this->data['versions_list'] = $this->front_version_model->get_product_versions_as_list($product);
		
		if($view) $this->layout->view('front/versions/item');
	}
	
	public function bom($id)
	{
		$this->layout_view = 'front/layouts/pdf';
		
		$this->load->library('pdf');
		
		// setting data for the view
		$this->show($id, FALSE);
		
		//$this->layout->view('front/pdf/product');
		
        $this->pdf->load_view('front/pdf/version', $this->data);
        $this->pdf->render();
        
        $filename = $this->data['version']->get_content('name') . '_' . date('Y-m-d_H.i.s').'.pdf';
		
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
