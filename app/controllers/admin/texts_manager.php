<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of texts
 *
 * @author alberto
 */
class Texts_manager extends Admin_controller{
	
	public $list = 'admin/contenuti/testi';


	function __construct() {
		parent::__construct();
		$this->load->model(array(
			'text_model'
		));
	}
	
	public function index()
	{
		$this->data['list'] = $this->text_model->get_all();
		
		$this->layout->view('texts/list');
	}
	
	public function form($id = FALSE)
	{
		$this->data['item'] = $this->text_model->get($id);
		
		$this->form_validation->set_rules($this->text_model->init_validation_rules($id));
		
		if($this->form_validation->run() == FALSE)
		{
			$this->layout->view('texts/form');
		}
		else
		{
			// save and redirect
			$data		= $this->input->post('text');
			$contents	= $this->input->post('content');
			
			$text_id = $this->text_model->save($id, $data, $contents);
			
			$this->set_message('success', 'Testo salvato con successo!');
			
			redirect($this->list);
		}
	}
	
	
	public function delete($id)
	{
		$this->text_model->delete($id);
		
		$this->set_message('success', 'Testo eliminato con successo!');
		redirect($this->list);
	}
}

?>
