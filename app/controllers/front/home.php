<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author Alberto
 */
class Home extends Front_controller {
    
    public function __construct() {
        parent::__construct();		
		$this->load->model('front/front_video_model');
    }
    
    public function index()
    {
		
		//$this->layout_view = 'layouts/home';
		
		$page		= $this->front_page_model->get_homepage();
		
		$news		= $this->front_news_model->get_last_news(8);
		
		$categories = $this->front_category_model->get_categories();
		
		/*
		$this->set_title($page->get_content('meta_title'));
		$this->set_keywords($page->get_content('meta_key'));
		$this->set_description($page->get_content('meta_descr'));
		 * 
		 */
		
		$this->data['page']			= $page;
		
		$this->data['news']			= $news;
		/*
		$this->data['showcase']		= $showcase;
		*/
        
		
        $this->layout->view('homepage');
    }
}

?>
