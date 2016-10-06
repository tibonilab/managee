<?php
/**
 * Description of types
 *
 * @author alberto
 */
class Types extends Admin_controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('type_model'));
    }
    
	function get_features_by_group_id_list($type_product_id = FALSE, $list = array())
	{
		$list = ($this->input->get('list')) ? $this->input->get('list') : $list;
		
		$groups = array();
		foreach($list as $group_id)
		{
			$groups[] = $this->type_model->get_group_by_group_id($group_id, $type_product_id);
		}

		if($this->input->is_ajax_request())
		{
			$data['versions_groups'] = $groups;
			$this->layout->load_view('types/snippets/versions', $data);
		}
		else
		{
			return $groups;
		}
	}
	
    function index()
    {
        $this->data['types'] = $this->type_model->get_all();
        $this->layout->view('types/list');
    }
    
    function form($id = FALSE)
    {
        $type = ($id) ? $this->type_model->get_type($id) : new Type();
        
        // view data
        $this->data['type_products']    = $type;    
        $this->data['groups']			= $this->type_model->get_groups_as_list();
		$this->data['related_groups']   = $this->type_model->get_related_groups($id);
		$this->data['versions_groups']	= $this->get_features_by_group_id_list($id, $this->data['related_groups']);
		
        // form validation
        $this->form_validation->set_rules($this->type_model->init_validation_rules($id));
        
        //var_dump($this->type_model->init_validation_rules($id));
        
        if($this->form_validation->run() == FALSE)
        {
            $this->layout->view('types/form');
        }
        else 
        {
            // save and redirect
            $type_data      = $this->input->post('type_products');
			$related_data	= $this->input->post('related');
			$version_data	= $this->input->post('version_features');
			
            $type_products_id = $this->type_model->save($id, $type_data, $related_data, $version_data);
            
            $this->set_message('success', 'Tipologia prodotti salvata con successo!');

            redirect('admin/prodotti/tipologie');
        }
    }
    
    function delete($id)
    {
        
    }
}

?>
