<?php

class Front_controller extends Main_controller {
    
	public $layout_view;
	
	public $environment		= 'front';
    public $language;
    
    public $iso;             // lang
    protected $akom;         // akom configs data
    protected $data			= array();  // data for the views
    
	public $texts;
    
    public function __construct() {
        parent::__construct();
		
		if($this->params->on_maintenance() AND ! in_array($_SERVER['REMOTE_ADDR'], $this->params->maintenance_access_ip()))
		{
			redirect(base_url('courtesy'), 'location', 302);
		}
		
        $this->iso = $this->uri->segment(1);
        
		if(strlen($this->iso) != 2)
		{
			$this->iso = 'it';
		}
		
        // no language in uri -> default language
        if( ! $this->iso)
        {
            $this->language = $this->language_model->get_default_language();
            $this->iso = $this->language->iso;
        }
        else
        {
            $this->language = $this->language_model->get_language($this->iso);

            // check if language exists and if is enabled, if not -> homepage
            if( ! $this->language OR ! $this->language->is_active())
            {
                redirect(home_url());
            }
        }
			
		if($this->iso == 'ar')
		{
			$this->layout->add_css('assets/front/css/ar.css');
			$this->data['lang_suffix'] = '_ar';
		}
		else
		{
			$this->data['lang_suffix'] = '';
		}
        
		//$this->_lang_redirect();
		
		
		// init custom texts
		$this->texts = new Texts();
				
		$this->data['languages'] = $this->language_model->get_languages(TRUE);
		
		// init modules
		$this->_init_modules();
		
        // init layout
        $this->_init_layout_data();
    }
	
	public function set_meta_by($item)
	{
		
		$title = $this->params->get('website_title') . ' | ';
		
		switch(get_class($item))
		{
			case 'Product':
			case 'Category':
				$title			.= ($item->get_content('meta_title') != '') ? $item->get_content('meta_title') : $item->get_content('name');
				$description	= ($item->get_content('meta_descr') != '') ? $item->get_content('meta_descr') : substr(strip_tags($item->get_content('description')), 0, 300);
				break;

			case 'Page':
			case 'Video':
			case 'Professional':
			case 'Offer':
				$title			.= ($item->get_content('meta_title') != '') ? $item->get_content('meta_title') : $item->get_content('title');
				$description	= ($item->get_content('meta_descr') != '') ? $item->get_content('meta_descr') : substr(strip_tags($item->get_content('content')), 0, 300);
				break;
		}
		
		
		
		
		$this->set_title($title);
		$this->set_description($description);
		$this->set_keywords($item->get_content('meta_key'));
		
	}
	
    public function set_title($title)
    {
        $this->layout->set_title($title);
    }
    
    public function set_keywords($keywords)
	{
        $this->layout->set_metadata('keywords', $keywords);
    }
  
    public function set_description($description)
	{
        $this->layout->set_metadata('description', $description);
    }
    
	private function _init_modules()
	{
		$this->load->model(array(
			'front/front_category_model', 
			'front/front_page_model', 
			'front/front_news_model', 
			'front/front_showcase_model', 
			'front/front_image_model',
			'front/front_product_model',
			'front/front_video_model',
			'front/front_professional_model',
			'front/front_offer_model')
		);
	}
	
    private function _init_layout_data()
    {
		$this->layout->set_theme($this->params->get('frontend_theme'));
		
        // default template data here
        $this->layout_view = 'layouts/default';
        
        // default metadata
        $this->set_title($this->params->get('default_title'));
        $this->set_keywords($this->params->get('default_keywords'));
        $this->set_description($this->params->get('default_description'));
		
		$this->data['categories']	= $this->front_category_model->get_categories();
		$this->data['showcase']		= $this->front_showcase_model->get_default_showcase();
		
		
		// load contents lang file
		$this->lang->load('content');
    }
	
	private function _lang_redirect()
	{
		//$this->session->unset_userdata('already_loaded');
		
		if( ! $this->session->userdata('already_loaded'))
		{
			$this->session->set_userdata('already_loaded', TRUE);
			$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
			if($lang != $this->iso  AND $this->language_model->lang_exists($lang))
			{
				redirect(base_url($lang));
			}
		}
	}
	
	
	protected function _view($view, $data = array(), $return = FALSE)
	{
		if ( $return )
		{
			return $this->layout->view($this->_views_path . '/' . $view, $data, $return);
		}
		else
		{
			$this->layout->view($this->_views_path . '/' . $view, $data, $return);
		}
		
	}
	
}

?>
