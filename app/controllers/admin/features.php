<?php

/**
 * Description of features
 *
 * @author Alberto
 */
class Features extends Admin_controller {
	
    function __construct() {
        parent::__construct();
        $this->load->model('feature_model');
        

    }
    
    private function _check_groups()
    {
        if(count($this->feature_model->get_groups_as_list()) == 0)
        {
            $this->set_message('info', 'E\' necessaria un\'operazione prima di poter accedere a questa sezione.');
            redirect('admin/prodotti/caratteristiche/oops');
        }
    }
    
    public function error()
    {
        $this->layout->view('features/error');
    }
    
    public function index()
    {
        $this->_check_groups();
        
        $features = $this->feature_model->get_all();
        
        $this->data['features'] = $features;
        
        $this->layout->view('features');
    }
    
    
    public function form($id = FALSE)
    {
        $this->_check_groups();
        
        if($id)
        {
            // get feature and languages content data
            $feature = $this->feature_model->get_feature($id);
        }
        else
        {
            $feature = new Feature();
        }
        
        // set view data
        $this->data['feature'] = $feature;
        $this->data['contents'] = $feature->get_contents();
        
        $this->data['groups']			= $this->feature_model->get_groups_as_list();
		$this->data['related_groups']   = $this->feature_model->get_related_groups($id);
		
        
        // form validation
        $this->form_validation->set_rules($this->feature_model->init_validation_rules($id));
        if($this->form_validation->run() == FALSE)
        {
            $this->layout->view('feature_form');
        }
        else 
        {
            // save and redirect
            $feature_data  = $this->input->post('feature');
            $content_data   = $this->input->post('content');
			$related_data	= $this->input->post('related');
            
            $feature_id = $this->feature_model->save($id, $feature_data, $content_data, $related_data);
            
            $this->set_message('success', 'Caratteristica salvata con successo!');

            redirect('admin/prodotti/caratteristiche');
        }
        
    }
    
    
    public function delete($id)
    {
        $feature = $this->feature_model->get_feature($id);
        
        if( ! $feature)
        {
            $this->set_message('warning', 'Impossibile trovare la caratteristica selezionata.');
            redirect('admin/prodotti/caratteristiche');
        }
        else
        {
            $this->feature_model->delete($feature);
            $this->set_message('success', 'Caratteristica eliminata con sucesso!');
            redirect('admin/prodotti/caratteristiche');
        }
    }
	
}

?>
