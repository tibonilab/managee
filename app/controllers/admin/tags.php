<?php


class Tags extends Admin_controller {
    
    function __construct() {
        parent::__construct();
		$this->load->model('tag_model');
    }
    
    public function index()
    {
		$this->set_data(['list' => $this->tag_model->get_all()]);
		
		if($this->input->post())
		{
			$this->tag_model->sort();
			$this->set_message('success', 'Ordinamento salvato con successo!');
			refresh();
		}
		
        $this->layout->view('tags/list');
    }
	
	public function form($id = NULL)
	{
		$item = $this->tag_model->get($id);
		
		$this->form_validation->set_rules($this->tag_model->init_validation_rules($id));
		if($this->form_validation->run() == FALSE)
		{
			$this->set_data(['item' => $item]);
			$this->layout->view('tags/form');
		}
		else
		{
			$this->tag_model->save($id);
			$this->set_message('success', 'Tag salvato con successo');
			
			if($id) refresh();
			else	redirect(base_url('admin/contenuti/tags'));
		}
	}
	
	public function delete($id)
	{
		$item = $this->tag_model->get($id);
		
		if( ! $item)
		{
			$this->set_message('error', 'Tag non trovato.');
		}
		else
		{
			$this->tag_model->delete($item);
			$this->set_message('success', 'Tag eliminato con successo.');
		}
		
		refresh();
	}
    
	
	public function ajax_get()
	{
		foreach($this->input->get('list') as $id)
		{
			echo $this->layout->load_view('tags/snippets/ajax_listed', array('item' => $this->tag_model->get($id), 'product_id' => $this->input->get('product_id')));
		}
	}
}

?>
