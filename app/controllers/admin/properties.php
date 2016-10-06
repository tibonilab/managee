<?php
/**
 * Description of properties
 *
 * @author alberto
 */
class Properties extends Admin_controller {
	//put your code here
	
	public $list = 'admin/prodotti/proprieta';
	
	function __construct() {
		parent::__construct();
        $this->load->model('property_model');
    }
    
    function index()
    {
        $this->data['properties'] = $this->property_model->get_all();
        $this->layout->view('properties/list');
    }
    
	private function _upload_icon()
	{
		$file_name = FALSE;

		// upload image only if selected
		if($_FILES['filename']['name'] != '')
		{
			$this->load->library('upload', $this->config->item('icons_upload_library_config'));

			//upload error
			if ( ! $this->upload->do_upload('filename')) 
			{
				$this->data['error'] = $this->upload->display_errors();
				$this->layout->view('properties/form');
			}
			else
			{
				$upload_data = $this->upload->data();
				$file_name = $upload_data['file_name'];
			}
		}
		return $file_name;
	}
	
	
	private function _delete_old_icon(Property $property)
	{
		if(file_exists($property->get_icon())) unlink($property->get_icon ());
	}
	
    function form($id = FALSE)
    {
        $property = ($id) ? $this->property_model->get_property($id) : new Property();
        
        // view data
        $this->data['property'] = $property;    
        //$this->data['groups']			= $this->property_model->get_groups_as_list();
		//$this->data['related_groups']   = $this->property_model->get_related_groups($id);
        
        // form validation
        $this->form_validation->set_rules($this->property_model->init_validation_rules($id));
        
        //var_dump($this->property_model->init_validation_rules($id));
        
        if($this->form_validation->run() == FALSE)
        {
            $this->layout->view('properties/form');
        }
        else 
        {
			$file_uploaded = $this->_upload_icon();
			
            // save and redirect
            $property_data			= $this->input->post('property');
			$content_data			= $this->input->post('content');
			
			if ( $file_uploaded )	
			{
				// set icon data
				$property_data['icon']	=  $file_uploaded;
				
				// delete old icon
				$this->_delete_old_icon($property);
			}
            
            $property_products_id = $this->property_model->save($id, $property_data, $content_data);
            
            $this->set_message('success', 'Proprietà salvata con successo!');

            redirect($this->list);
        }
    }
    
	
	
    function delete($id)
    {
        $item = $this->property_model->get_property($id);
		
		if( ! $item)
		{
			$this->set_message('warning', 'Impossibile trovare la proprietà selezionata.');
			redirect($this->list);
		}
		else
		{
			$this->property_model->delete($item);
			$this->set_message('success', 'Proprietà eliminata con successo!');
			redirect($this->list);
		}
    }
}

?>
