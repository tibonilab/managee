<?php
/**
 * Description of products
 *
 * @author Alberto
 */
class Categories extends Admin_controller {
	
	private $_redirects		= array(
								'pages'			=> 'admin/contenuti/pagine/categorie',
								'properties'	=> 'admin/strutture/servizi/categorie'
							);
			
	
    function __construct() {
        parent::__construct();
        $this->load->model('category_model');
		
		$this->module = 'products';
    }
    
    public function index($module = NULL)
    {
		if($module)
		{
			$this->module = $module;
		}
		
        $categories = $this->category_model->get_all(0, $this->module);
        
        $this->data['categories'] = $categories;
        
        $this->layout->view('product_categories/list');
    }
    
    
    public function form($module, $id = FALSE)
    {
		$this->module = $module;
		
        if($id)
        {
            // get category and languages content data
            $category = $this->category_model->get_category($id);
            $contents = $category->get_contents();
        }
        else
        {
            $category = new Category($this->input->get('parent_id'), $module);
            
            // set empty languages content
            $contents = array();
            foreach($this->languages as $lang)
            {
                $content = new Category_content();
                $content->iso = $lang->iso;
                
                $contents[$lang->iso] = $content;
            }
        }
        
        // set view data
        $this->data['category'] = $category;
        $this->data['contents'] = $contents;
        
        $this->data['categories']   = $this->category_model->get_all_as_list($module);
        
        // form validation
        $this->form_validation->set_rules($this->category_model->init_validation_rules($category));
        if($this->form_validation->run() == FALSE)
        {
			$this->data['images']   = $category->get_images();
			
			// recover uploaded images on failed validation
            $this->data['uploaded'] = '';
            if(isset($_POST['image']['id']) AND count($_POST['image']['id'])>0)
            {   
                foreach($_POST['image']['id'] as $id)
                {
                    $this->data['uploaded'] .= $this->ajax_image($id, 'product_categories');
                }
            }
			
			
            $this->layout->view('product_categories/form');
        }
        else 
        {
            // save and redirect
            $category_data  = $this->input->post('category');
            $content_data   = $this->input->post('content');
            $image_data		= $this->input->post('image');
			
            $category_id = $this->category_model->save($id, $category_data, $content_data, $image_data);
            
            $this->set_message('success', 'Categoria salvata con successo!');

            $this->_redirect();
        }
        
		
    }
	
	
	private function _redirect()
	{
		redirect($this->_redirects[$this->module]);
	}
    
    
    public function delete($module, $id)
    {
		$this->module = $module;
		
        $category = $this->category_model->get_category($id);
        
        if( ! $category)
        {
            $this->set_message('warning', 'Impossibile trovare la categoria selezionata.');
            $this->_redirect();
        }
        else
        {
            $this->category_model->delete($category);
            $this->set_message('success', 'Categoria eliminata con sucesso!');
            $this->_redirect();
        }
    }
    
    
    public function sort()
    {
        if($this->input->is_ajax_request())
        {
            $list = $_REQUEST['list'];
            $this->category_model->sort($list);
        }
        else
        {
            echo ";-P";
        }
    }
}

?>
