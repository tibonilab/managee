<?php
/**
 * Description of languages
 *
 * @author Alberto
 */
class Languages extends Admin_controller {
	
	function __construct() {
		parent::__construct();
	}
	
	public function index()
	{
		$this->data['list'] = $this->language_model->get_all(TRUE);
		
		$this->layout->view('languages/list');
	}
	
	public function form($iso = FALSE)
	{
		if($iso)
		{
			$this->data['iso']			= $iso;
		}
		else
		{
			$this->data['langs_list']	= $this->language_model->get_languages();
		}
		
		$this->data['item'] = $this->language_model->get($iso);
		
		$this->form_validation->set_rules('iso', 'Sigla', 'is_unique[languages.iso]');
		$this->form_validation->set_rules('description', 'Descrizione', '');
		$this->form_validation->set_rules('sign', 'Sigla visualizzata', '');
		$this->form_validation->set_rules('state', 'Sigla stato', '');
		$this->form_validation->set_rules('default', '', '');
		$this->form_validation->set_rules('active', '', '');
		
		if ( $this->form_validation->run() == FALSE )
		{
			$this->layout->view('languages/form');
		}
		else
		{
			$item_data	= $this->input->post('item');
			if( ! $iso)
			{
				$copy_from	= $this->input->post('copy_from');

				$this->set_message('success', 'Lingua aggiunta con successo!');
				$this->language_model->create_language($copy_from, $item_data);
			}
			else
			{
				$this->set_message('success', 'Lingua modificata con successo!');
				$this->language_model->update_language($iso, $item_data);
			}
			redirect('admin/languages');
		}
	}
}




?>
