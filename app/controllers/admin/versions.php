<?php

/**
 * Description of versions
 *
 * @author alberto
 */
class Versions extends Admin_controller{
	//put your code here
	
	function __construct() {
		parent::__construct();
		$this->load->model(array('version_model', 'product_model', 'type_model', 'link_model'));
	}
	
	public function form($product_id, $version_id = FALSE)
	{
		$product = $this->product_model->get_product($product_id);
		
		if($version_id)
		{
			$version = $this->version_model->get($version_id, $product);
		}
		else
		{
			$version = new Version();
			
			// set features and type for new version
			$version->set_groups_features($this->version_model->get_features_values($product->type_products_id));
			$version->type_product_id = $product->type_products_id;
		}
		
		$this->data['product']		= $product;
		$this->data['version']		= $version;
		$this->data['links_list']	= $this->link_model->get_all_for_version($version_id);
		
		$this->form_validation->set_rules($this->version_model->init_validation_rules($version));
		
		if($this->form_validation->run() == FALSE)
		{
			$this->data['images']   = $version->get_images();
			
			// recover uploaded images on failed validation
            $this->data['uploaded'] = '';
            if(isset($_POST['image']['id']) AND count($_POST['image']['id'])>0)
            {   
                foreach($_POST['image']['id'] as $id)
                {
                    $this->data['uploaded'] .= $this->ajax_image($id, 'versions');
                }
            }
			
			$this->layout->view('versions/form');
		}
		else
		{
			// save and redirect
			$version_data		= $this->input->post('version');
            $content_data		= $this->input->post('content');
            $features_data		= $this->input->post('features');
            $image_data			= $this->input->post('image');
			$links_data			= array(
						'links'			=> $this->input->post('links'), 
						'link_contents' => $this->input->post('link_contents')
					);
            
			// let's save
            $version_id = $this->version_model->save($version_id, $version_data, $content_data, $image_data, $features_data, $links_data);
            
            $this->set_message('success', 'Versione prodotto salvata con successo!');
			
			redirect('admin/luoghi/inventario/modifica/'.$product_id.'#versions');
		}
		
		
		
	}
	
	
	public function delete($id)
	{
		$item = $this->version_model->get_for_delete($id);
		
		if( ! $item)
		{
			$this->set_message('error', 'Impossibile trovare la versione selezionata');
			redirect('admin/luoghi/inventario');
		}
		else 
		{
			$this->version_model->delete($item);
			$this->set_message('success', 'Versione eliminata con successo');
			redirect('admin/luoghi/inventario/modifica/'.$item->product_id.'#versions');
		}
	}
	
}

?>
