<?php
/**
 * Description of groups_features
 *
 * @author alberto
 */
class Groups_features extends Admin_controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('group_features_model');
    }
    
    public function index()
    {
        $this->data['groups_features'] = $this->group_features_model->get_all();
        
        $this->layout->view('groups_features');
    }
    
    public function form($id = NULL)
    {
        $group = ($id) ? $this->group_features_model->get($id) : new Group_features();
        
        $this->form_validation->set_rules($this->group_features_model->init_validation_rules());
        
        if($this->form_validation->run() == FALSE)
        {
            $this->data['group_features'] = $group;
            $this->layout->view('group_features_form');
        }
        else
        {
            // save and redirect
            $group_features_data    = $this->input->post('group_features');
            $content_data           = $this->input->post('content');
            
            $group_features_id = $this->group_features_model->save($id, $group_features_data, $content_data);
                    
            $this->set_message('success', 'Gruppo caratteristiche salvato con successo !');
            redirect('admin/prodotti/gruppi-caratteristiche');
        }
    }
    
    
        public function delete($id)
    {
        $group_features = $this->group_features_model->get($id);
        
        if( ! $group_features)
        {
            $this->set_message('warning', 'Impossibile trovare il gruppo caratteristiche selezionato.');
            redirect('admin/prodotti/gruppi-caratteristiche');
        }
        else
        {
            $this->group_features_model->delete($group_features);
            $this->set_message('success', 'Gruppo caratteristiche eliminato con sucesso!');
            redirect('admin/prodotti/gruppi-caratteristiche');
        }
    }
}

?>
