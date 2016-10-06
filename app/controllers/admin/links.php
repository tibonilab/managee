<?php
/**
 * Description of links
 *
 * @author alberto
 */
class Links extends Admin_controller {
	//put your code here
	
	public $list_route = 'admin/prodotti/links';
	
	function __construct() {
		parent::__construct();
        $this->load->model('link_model');
    }
    
    function index()
    {
        $this->data['list'] = $this->link_model->get_all(TRUE);
        $this->layout->view('links/list');
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
				$this->layout->view('links/form');
			}
			else
			{
				$upload_data = $this->upload->data();
				$file_name = $upload_data['file_name'];
			}
		}
		return $file_name;
	}
	
	
	private function _delete_old_icon(Link $link)
	{
		if(file_exists($link->get_icon()) AND ! empty($link->icon)) unlink($link->get_icon ());
	}
	
    function form($id = FALSE)
    {
        $link = ($id) ? $this->link_model->get_link($id) : new Link();
        
        // view data
        $this->data['item'] = $link;    

        
        // form validation
        $this->form_validation->set_rules($this->link_model->init_validation_rules($id));
        
        if($this->form_validation->run() == FALSE)
        {
            $this->layout->view('links/form');
        }
        else 
        {
			$file_uploaded = $this->_upload_icon();
			
            // save and redirect
            $link_data			= $this->input->post('link');
			$content_data			= $this->input->post('content');
			
			if ( $file_uploaded )	
			{
				// set icon data
				$link_data['icon']	=  $file_uploaded;
				
				// delete old icon
				$this->_delete_old_icon($link);
			}
            
            $link_products_id = $this->link_model->save($id, $link_data, $content_data);
            
            $this->set_message('success', 'Link salvato con successo!');

            redirect($this->list_route);
        }
    }
    
	
	
    function delete($id)
    {
        $item = $this->link_model->get_link($id);
		
		if( ! $item)
		{
			$this->set_message('warning', 'Impossibile trovare il link selezionata.');
			redirect($this->list_route);
		}
		else
		{
			$this->link_model->delete($item);
			$this->set_message('success', 'Link eliminato con successo!');
			redirect($this->list_route);
		}
    }
}

?>
