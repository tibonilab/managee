<?php
/**
 * Description of partners
 *
 * @author Alberto
 */
class Partners extends Admin_controller {
    
	public $list = 'admin/contenuti/partners';
	
    function __construct() {
        parent::__construct();
        $this->load->model(array('partner_model', 'showcase_model'));
    }
    
    public function index()
    {
        $partners = $this->partner_model->get_all();
        $this->data['partners'] = $partners;
        
		if($this->input->post())
		{
			$this->partner_model->sort();
			$this->set_message('success', 'Ordinamento salvato con successo!');
			refresh();
		}
		
        $this->layout->view('partners/list');
    }
    
    
    public function form($id = FALSE)
    {
        if($id)
        {
            // get partner data
            $partner = $this->partner_model->get_partner($id);
        }
        else
        {
            // create an empty partner
            $partner = new Partner();
        }
        
        // set view data
        $this->data['partner']			= $partner;
 
		
        // form validation
        $this->form_validation->set_rules($this->partner_model->init_validation_rules($id));
        if($this->form_validation->run() == FALSE)
        {
			
			
            $this->layout->view('partners/form');
        }
        else 
        {
            $partner_id = $this->partner_model->save($id);
            
            $this->set_message('success', 'Pagina salvata con successo!');

            redirect($this->list);
            
        }
        
    }
    
    
    public function delete($id)
    {
        $partner = $this->partner_model->get_partner($id);
        
        if( ! $partner)
        {
            $this->set_message('warning', 'Impossibile trovare la pagina selezionata.');
            redirect($this->list);
        }
        else
        {
            $this->partner_model->delete($partner);
            $this->set_message('success', 'Pagina eliminata con sucesso!');
            redirect($this->list);
        }
    }
}

?>
