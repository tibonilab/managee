<?php
/**
 * Description of pages
 *
 * @author Alberto
 */
class Pages extends Admin_controller {
    
	public $list = 'admin/contenuti/pagine';
	
    function __construct() {
        parent::__construct();
        
		$this->load->model(array(
			'page_model', 
			'showcase_model',
            'category_model',
            'tag_model'
		));
    }
    
    public function index($filter = NULL)
    {
        $pages = $this->page_model->get_all($filter);
        
		$this->data['categories_list'] = array('Filtra per categoria') + $this->category_model->get_all_as_list('pages');
		$this->data['category_id'] = $filter;
        $this->data['pages'] = $pages;
        
		if($filter AND ! $this->session->flashdata('success'))
		{
			$this->data['infomsg'] = 'Puoi ordinare gli elemanti trascinandoli.';
		}
		
		if($this->input->post())
		{
			$this->page_model->sort();
			$this->set_message('success', 'Ordinamento salvato con successo!');
			redirect($_SERVER['HTTP_REFERER']);
		}
		
        $this->layout->view('pages/list');
    }
    
    
    public function form($id = FALSE)
    {
        if($id)
        {
            // get page data
            $page = $this->page_model->get_page($id);
        }
        else
        {
            // create an empty page
            $page = new Page();
        }
        
        // set view data
        $this->data['page']			= $page;
        $this->data['contents']		= $page->get_contents();
        $this->data['showcases']	= $this->showcase_model->get_all(TRUE);
		$this->data['categories']	= array('Nessuna categoria') + $this->category_model->get_all_as_list('pages');
        $this->data['tags']         = $this->tag_model->get_all_as_list();
        
        // form validation
        $this->form_validation->set_rules($this->page_model->init_validation_rules($id));
        if($this->form_validation->run() == FALSE)
        {
			// recover uploaded images on failed validation
            $this->_recover_post_image_data($page, 'pages');
			
            $this->layout->view('pages/form');
        }
        else 
        {
            // save and redirect
            $page_data			= $this->input->post('page');
            $content_data		= $this->input->post('content');
            $image_data			= $this->input->post('image');            
			
            $page_id = $this->page_model->save($id, $page_data, $content_data, $image_data);
            
            $this->set_message('success', 'Pagina salvata con successo!');

            redirect($this->list);
            
        }
        
    }
    
    
    public function delete($id)
    {
        $page = $this->page_model->get_page($id);
        
        if( ! $page)
        {
            $this->set_message('warning', 'Impossibile trovare la pagina selezionata.');
            redirect($this->list);
        }
        else
        {
            $this->page_model->delete($page);
            $this->set_message('success', 'Pagina eliminata con sucesso!');
            redirect($this->list);
        }
    }
}

?>
