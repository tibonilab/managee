<?php
/**
 * Description of professionals
 *
 * @author Alberto
 */
class Professionals extends Admin_controller {
    
	public $list = 'admin/contenuti/team';
	
    function __construct() {
        parent::__construct();
        $this->load->model(array('professional_model', 'showcase_model'));
    }
    
    public function index()
    {
        $professionals = $this->professional_model->get_all();
        $this->data['professionals'] = $professionals;
        
		if($this->input->post())
		{
			$this->professional_model->sort();
			$this->set_message('success', 'Ordinamento salvato con successo!');
			refresh();
		}
		
        $this->layout->view('professionals/list');
    }
    
    
    public function form($id = FALSE)
    {
        if($id)
        {
            // get professional data
            $professional = $this->professional_model->get_professional($id);
        }
        else
        {
            // create an empty professional
            $professional = new Professional();
        }
        
        // set view data
        $this->data['professional']			= $professional;
        $this->data['contents']		= $professional->get_contents();
        $this->data['showcases']	= $this->showcase_model->get_all(TRUE);
		
        // form validation
        $this->form_validation->set_rules($this->professional_model->init_validation_rules($id));
        if($this->form_validation->run() == FALSE)
        {
			// recover uploaded images on failed validation
            $this->_recover_post_image_data($professional, 'professionals');
			
            $this->layout->view('professionals/form');
        }
        else 
        {
            // save and redirect
            $professional_data			= $this->input->post('professional');
            $content_data		= $this->input->post('content');
            $image_data			= $this->input->post('image');
			
            $professional_id = $this->professional_model->save($id, $professional_data, $content_data, $image_data);
            
            $this->set_message('success', 'Pagina salvata con successo!');

            redirect($this->list);
            
        }
        
    }
    
    
    public function delete($id)
    {
        $professional = $this->professional_model->get_professional($id);
        
        if( ! $professional)
        {
            $this->set_message('warning', 'Impossibile trovare la pagina selezionata.');
            redirect($this->list);
        }
        else
        {
            $this->professional_model->delete($professional);
            $this->set_message('success', 'Pagina eliminata con sucesso!');
            redirect($this->list);
        }
    }
}

?>
