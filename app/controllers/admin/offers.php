<?php
/**
 * Description of offers
 *
 * @author Alberto
 */
class Offers extends Admin_controller {
    
	public $list = 'admin/contenuti/offerte';
	
    function __construct() {
        parent::__construct();
        $this->load->model(array('offer_model', 'showcase_model'));
    }
    
    public function index()
    {
        $offers = $this->offer_model->get_all();
        $this->data['offers'] = $offers;
        
		if($this->input->post())
		{
			$this->offer_model->sort();
			$this->set_message('success', 'Ordinamento salvato con successo!');
			refresh();
		}
		
        $this->layout->view('offers/list');
    }
    
    
    public function form($id = FALSE)
    {
        if($id)
        {
            // get offer data
            $offer = $this->offer_model->get_offer($id);
        }
        else
        {
            // create an empty offer
            $offer = new Offer();
        }
        
        // set view data
        $this->data['offer']			= $offer;
        $this->data['contents']		= $offer->get_contents();
        $this->data['showcases']	= $this->showcase_model->get_all(TRUE);
		
        // form validation
        $this->form_validation->set_rules($this->offer_model->init_validation_rules($id));
        if($this->form_validation->run() == FALSE)
        {
			// recover uploaded images on failed validation
            $this->_recover_post_image_data($offer, 'offers');
			
            $this->layout->view('offers/form');
        }
        else 
        {
            // save and redirect
            $offer_data			= $this->input->post('offer');
            $content_data		= $this->input->post('content');
            $image_data			= $this->input->post('image');
			
            $offer_id = $this->offer_model->save($id, $offer_data, $content_data, $image_data);
            
            $this->set_message('success', 'Pagina salvata con successo!');

            redirect($this->list);
            
        }
        
    }
    
    
    public function delete($id)
    {
        $offer = $this->offer_model->get_offer($id);
        
        if( ! $offer)
        {
            $this->set_message('warning', 'Impossibile trovare la pagina selezionata.');
            redirect($this->list);
        }
        else
        {
            $this->offer_model->delete($offer);
            $this->set_message('success', 'Pagina eliminata con sucesso!');
            redirect($this->list);
        }
    }
}

?>
