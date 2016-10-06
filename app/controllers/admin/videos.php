<?php
/**
 * Description of products
 *
 * @author Alberto
 */
class Videos extends Admin_controller {
    
    function __construct() {
        parent::__construct();
		$this->load->model('video_model');
		$this->load->model('partner_model');
    }
    
    public function index()
    {
		$this->data['list'] = $this->video_model->get_all();
		
		if($this->input->post())
		{
			$this->video_model->sort();
			$this->set_message('success', 'Ordinamento salvato con successo!');
			refresh();
		}
		
        $this->layout->view('videos/list');
    }
	
	public function form($id = NULL)
	{
		$item = $this->video_model->get($id);
		
		$this->form_validation->set_rules($this->video_model->init_validation_rules($id));
		if($this->form_validation->run() == FALSE)
		{
			$this->data['item'] = $item;
			$this->layout->view('videos/form');
		}
		else
		{
			$this->video_model->save($id);
			$this->set_message('success', 'Video salvato con successo');
			
			if($id) refresh();
			else	redirect(base_url('admin/multimedia/video'));
		}
	}
	
	public function delete($id)
	{
		$item = $this->video_model->get($id);
		
		if( ! $item)
		{
			$this->set_message('error', 'Video non trovato.');
		}
		else
		{
			$this->video_model->delete($item);
			$this->set_message('success', 'Video eliminato con successo.');
		}
		
		refresh();
	}
    
	
	public function ajax_get()
	{
		foreach($this->input->get('list') as $id)
		{
			echo $this->layout->load_view('videos/snippets/ajax_listed', array('item' => $this->video_model->get($id), 'product_id' => $this->input->get('product_id')));
		}
	}
}

?>
