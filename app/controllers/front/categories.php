<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of categories
 *
 * @author alberto
 */
class Categories extends Front_controller {
	
	protected $_views_path = 'categories';
	
	function __construct() {
		parent::__construct();
		$this->load->model(array(
			'front/front_property_model', 
			'front/front_group_features_model', 
			'front/front_product_model', 
			'front/front_image_model', 
			'front/front_feature_model',
			'front/front_category_model')
		);
		
		//$this->data['breadcrumbs']['first_item'] = array('url' => site_url('photo'), 'label' => 'Photo');
	}
	
	public function show($id)
	{
		$category = $this->front_category_model->get($id);
		
		if($category AND $category->is_published())
		{
			$this->set_meta_by($category);
			
			$this->data['category'] = $category;
			$this->data['breadcrumbs']['list'] = $this->front_category_model->get_breadcrumbs($category);

			$this->_view('item');
		}
		else
		{
			redirect(home_url(), 'location', 301);
		}
	}

	
	public function index()
	{
		$this->_view('index');
	}
	
}

?>