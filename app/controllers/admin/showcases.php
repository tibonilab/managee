<?php
/**
 * Description of products
 *
 * @author Alberto
 */
class Showcases extends Admin_controller {
    
	public $list = 'admin/contenuti/gallerie';
	
    function __construct() {
        parent::__construct();
		
		$this->load->model(array('showcase_model', 'image_model'));
    }
    
    public function index()
    {
		// set default showcase
		$this->_set_default();
		
		$this->db->where('featured', 0);
		$this->data['showcases'] = $this->showcase_model->get_all();
		
		$this->db->where('featured', 1);
		$this->data['groups'] = $this->showcase_model->get_all();
		
		
        $this->layout->view('showcases/list');
    }
	
	
	// set default showcase and refresh
	private function _set_default()
	{
		if($this->input->post('default'))
		{
			$this->db->update('showcases',array('default' => 0));
			$this->db->where('id', $this->input->post('default'));
			$this->db->update('showcases',array('default' => 1));
			
			$this->set_message('success', 'Vetrina predefinita aggiornata con successo!');
			redirect($this->list);
		}
	}
	
	
	public function form_featured($id = FALSE)
	{
		$showcase = $this->showcase_model->get($id);
		
		$this->form_validation->set_rules($this->showcase_model->init_validation_rules($showcase));
		
		if($this->form_validation->run() == FALSE)
		{
			$this->data['showcase'] = $showcase;
			$this->layout->view('showcases/form_featured');
		}
		else
		{
			$data		= $this->input->post('showcase');
			$products	= $this->input->post('products');
			
			$this->showcase_model->save_featured($id, $data, $products);

			$this->set_message('success', 'Lista prodotti salvata con successo!');
			redirect($this->list);		
		}
	}
	
	
	public function form($id = FALSE)
	{
		$showcase = $this->showcase_model->get($id);
		
		
		
		$this->form_validation->set_rules($this->showcase_model->init_validation_rules($showcase));
		if($this->form_validation->run() == FALSE)
		{
			$this->data['showcase'] = $showcase;
			
			// recover uploaded images on failed validation
			$this->_recover_uploaded_images();
			
			$this->layout->view('showcases/form');
		}
		else 
		{
			//save and redirect
			$data		= $this->input->post('showcase');
			$images		= $this->input->post('image');
			$contents	= $this->input->post('content');
			
			$showcase_id = $this->showcase_model->save($id, $data, $images, $contents);
			
			$this->set_message('success', 'Vetrina salvata con successo!');
			redirect($this->list);
		}
	}
	
	public function delete($id)
	{
		$showcase = $this->showcase_model->get($id);
		
		if ( ! $showcase )
		{
			$this->set_message('warning', 'Impossibile trovare la vetrina selezionata.');
			redirect($this->list);
		}  
		else
		{
			$this->showcase_model->delete($showcase);
			$this->set_message('success', 'Vetrina eliminata con successo!');
			redirect($this->list);
		}
	}
    
	
	
	private function _recover_uploaded_images()
	{
		$this->data['uploaded'] = '';
		if(isset($_POST['image']['id']) AND count($_POST['image']['id'])>0)
		{   
			foreach($_POST['image']['id'] as $id)
			{
				$this->data['uploaded'] .= $this->ajax_image($id, 'showcases');
			}
		}
	}
}

?>
