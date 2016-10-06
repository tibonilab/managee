<?php 

class Admin_controller extends Main_controller {
    
    public $layout_view = 'layouts/default';
    public $languages   = array();
    
	public $environment	= 'admin';
	
    public function __construct() {
        parent::__construct();
		
		// auth init
        $this->load->library('ion_auth');
		$this->lang->load('auth');
        
        // check login
        $this->_check_login();
		
		// languages init
        $this->languages = $this->language_model->get_all();
        
        // pass languages on views
        $this->data['languages'] = $this->languages;
        
        $this->form_validation->set_error_delimiters('<p class="validation_error">', '</p>');
		
		
		$this->layout->set_theme('admin');
    }
    
    public function ajax_image($id, $type = 'products')
    {
        $this->load->model('image_model');
        
        $image = $this->image_model->get_image($id);
        
        $data['image']      = $image;
        $data['contents']   = $image->get_contents();
        
        return $this->layout->load_view($type.'/snippets/image', $data);
    }
	
	public function ajax_attachment($id, $type)
    {
        $this->load->model('attachment_model');
        
        $attachment = $this->attachment_model->get($id);
        
        $data['attachment']      = $attachment;
        
        return $this->layout->load_view($type.'/snippets/attachment', $data);
    }
	
	private function _check_login()
    {
        if ( ! $this->ion_auth->logged_in())
		{
            $this->session->set_userdata('request', uri_string());
			//redirect them to the login page
			
			if(uri_string() != 'login' AND uri_string() != 'auth/login') 
			{
				redirect(base_url('login'), 'refresh');
			}
		}
        
    }
	
	protected function _recover_post_image_data($item, $type = 'products')
	{
		// recover uploaded images on failed validation
		$this->data['uploaded'] = '';
		if(isset($_POST['image']['id']) AND count($_POST['image']['id'])>0)
		{   
			foreach($_POST['image']['id'] as $id)
			{
				$insert = TRUE;
				foreach($item->get_images() as $image)
				{
					if($image->id == $id) $insert = FALSE;
				}

				if($insert) $this->data['uploaded'] .= $this->ajax_image($id, $type);
			}
		}
	}
	
	protected function _view($view = NULL, $data = array(), $return = FALSE)
	{
		$path = '';//strtolower($this->router->fetch_class());
		$view = ($view) ? $view : strtolower($this->router->fetch_method());
		
		if ( $return )
		{
			return $this->layout->view($path . '/' . $view, $data, $return);
		}
		else
		{
			$this->layout->view($path . '/' . $view, $data, $return);
		}
		
	}
}

?>