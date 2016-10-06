<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of news
 *
 * @author Alberto
 */
class News extends Admin_controller {
	
    function __construct() {
        parent::__construct();
        $this->load->model('news_model');
    }
     
    public function index()
    {
        $news = $this->news_model->get_all();
        $this->data['news'] = $news;
        
        $this->layout->view('news/list');
    }
    
    
    public function form($id = FALSE)
    {
        if($id)
        {
            // get news data
            $news = $this->news_model->get_news($id);
        }
        else
        {
            // create an empty news
            $news = new News_lib();
        }
        
        // set view data
        $this->data['news']     = $news;
        $this->data['contents'] = $news->get_contents();
        
        // form validation
        $this->form_validation->set_rules($this->news_model->init_validation_rules($id));
        if($this->form_validation->run() == FALSE)
        {
			// recover uploaded images on failed validation
            $this->_recover_post_image_data($news, 'pages');
			
            $this->layout->view('news/form');
        }
        else 
        {
            // save and redirect
            $news_data			= $this->input->post('news');
            $content_data		= $this->input->post('content');
			$image_data			= $this->input->post('image');
            
            $news_id = $this->news_model->save($id, $news_data, $content_data, $image_data);
            
            $this->set_message('success', 'News salvata con successo!');

            redirect('admin/contenuti/news');
            
        }
        
    }
    
    
    public function delete($id)
    {
        $news = $this->news_model->get_news($id);
        
        if( ! $news)
        {
            $this->set_message('warning', 'Impossibile trovare la news selezionata.');
            redirect('admin/contenuti/news');
        }
        else
        {
            $this->news_model->delete($news);
            $this->set_message('success', 'News eliminata con sucesso!');
            redirect('admin/contenuti/news');
        }
    }
	
}

?>
