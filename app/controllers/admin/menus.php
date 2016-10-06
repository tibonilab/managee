<?php
/**
 * Description of menus
 *
 * @author Alberto
 */
class Menus extends Admin_controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->load->model('menu_model');
	}

	private function _delete_old_icon(Menu_item $menu_item)
	{
		$old_icon = './assets/'.$this->params->get('frontend_theme') . '/images/menu_items/' . $menu_item->icon;
		
		if(file_exists($old_icon)) unlink($old_icon);
	}
	
	private function _upload_icon()
	{
		$file_name = FALSE;

		// upload image only if selected
		if($_FILES['image']['name'] != '')
		{
			$config = array(
				'upload_path'       => './assets/'.$this->params->get('frontend_theme') . '/images/menu_items/',
				'allowed_types'     => 'gif|jpg|jpeg|png',
				'max_size'          => '4096'
			);
			
			$this->load->library('upload', $config);

			//upload error
			if ( ! $this->upload->do_upload('image')) 
			{
				$this->data['error'] = $this->upload->display_errors();
				$this->layout->view('menus/form_item');
			}
			else
			{
				$upload_data = $this->upload->data();
				$file_name = $upload_data['file_name'];
			}
		}
		
		return $file_name;
	}
	
	

	
	public function ajax_entity_list($entity, $default = FALSE)
	{
		if($this->input->is_ajax_request())
		{
			if($entity)
			{
				$list = $this->db->get($entity)->result();
				
				$array = array('Seleziona');
				foreach($list as $item)
				{
					$array[$item->id] = $item->name; 
				}
				
				echo form_dropdown('item[entity_id]', $array, $default, 'class="span12" id="entity_id"');
			}
			else
			{
				echo 0;
			}
		}
		
	}
	
	public function ajax_sort_menu_items()
	{
		if($this->input->is_ajax_request())
		{
			$list = $_REQUEST['list'];
			$this->menu_model->sort($list);
		}
	}
	
	public function menu_item_form($menu_id, $menu_item_id = FALSE)
	{
		$menu_item = $this->menu_model->get_menu_item($menu_id, $menu_item_id);
		
		$this->form_validation->set_rules($this->menu_model->init_menu_item_validation_rules($menu_item_id));
				
		if($this->form_validation->run() == FALSE )
		{
			$this->data['menu_item'] = $menu_item;
			$this->layout->view('menus/form_item');
		}
		else
		{
			$file_uploaded = $this->_upload_icon();

			if ( $file_uploaded AND $menu_item->icon)	
			{
				// delete old icon
				$this->_delete_old_icon($menu_item);
			}
			
			$this->menu_model->save_menu_item($menu_item_id, $file_uploaded);
			$this->set_message('success', 'Voce di menu salvata con successo.');
			redirect('admin/contenuti/menu/modifica/' . $menu_id);
		}
		
	}
	
	public function index()
	{
		$this->data['list'] = $this->menu_model->get_all();
		
		$this->layout->view('menus/list');
	}
	
	public function delete($id)
	{
		$this->menu_model->delete($id);
		$this->set_message('success', 'Menu eliminato con successo.');
		redirect(base_url('admin/contenuti/menu'));
	}
	
	public function delete_menu_item($menu_id, $menu_item_id)
	{
		$item = $this->menu_model->get_menu_item($menu_id, $menu_item_id);
		
		$this->menu_model->delete_menu_item($item);
		
		$this->set_message('success', 'Voce di menù eliminata con successo.');
		redirect(base_url('admin/contenuti/menu/modifica/' . $menu_id));
	}
	
	public function form($id = FALSE)
	{
		$item = $this->menu_model->get($id);
		
		$this->form_validation->set_rules($this->menu_model->init_validation_rules($id));
		
		if($this->form_validation->run() == FALSE )
		{
			$this->data['item'] = $item;
			
			$this->layout->view('menus/form');
		}
		else
		{
			$id = $this->menu_model->save($id);
			$this->set_message('success', 'Menu salvato con successo.');
			redirect('admin/contenuti/menu/modifica/' . $id);
		}
		
	}
	
	public function remove_item_image($menu_id, $menu_item_id)
	{
		$item = $this->menu_model->get_menu_item($menu_id, $menu_item_id);
		
		$this->menu_model->delete_menu_item_image($item, TRUE);
	}
}

?>