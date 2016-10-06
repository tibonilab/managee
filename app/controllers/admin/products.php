<?php
/**
 * Description of products
 *
 * @author Alberto
 */
class Products extends Admin_controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model(array('product_model', 'link_model', 'category_model', 'type_model', 'property_model', 'version_model', 'video_model'));
        //$this->load->library(array('product', 'product_content', 'category', 'category_content'));
        
        $this->load->model('image_model');
        //$this->load->library(array('image', 'image_content'));
        
    }
    
    public function get_features_by_type_product_id($id)
    {
        $product = new Product();
        $product->set_groups_features($this->type_model->get_related_groups($id, FALSE));
        
		if($this->input->is_ajax_request())
		{
			$data['product'] = $product;
			echo $this->layout->load_view('products/snippets/features', $data);
		}
		else
		{
			return $product->get_groups_features();
		}
    }
    
    public function index($filter = NULL)
    {
        $products = $this->product_model->get_all($filter);
        
        $this->data['products'] = $products;
        $this->data['categories_list'] = $this->category_model->get_all_as_list();
		$this->data['categories_list'][0] = 'Filtra per categoria';
		$this->data['category_id'] = $filter;
		
		if($filter AND ! $this->session->flashdata('success'))
		{
			$this->data['infomsg'] = 'Puoi ordinare gli elemanti trascinandoli.';
		}
		
		if($this->input->post())
		{
			$this->product_model->sort();
			$this->set_message('success', 'Ordinamento salvato con successo!');
			redirect($_SERVER['HTTP_REFERER']);
		}
		
        $this->layout->view('products/products');
    }
    
      
    public function form($id = FALSE, $filter = NULL)
    {
        if($id)
        {
            // get product and languages content data
            $product = $this->product_model->get_product($id);
        }
        else
        {
            // create an empty product
            $product = new Product();
        }
		
        // set view data
        $this->data['product']  = $product;
        $this->data['contents'] = $product->get_contents();
                
        $this->data['categories']       = $this->category_model->get_all_as_list();
        $this->data['types_products']   = $this->type_model->get_all_as_list(TRUE);
		$this->data['properties']		= $properties = $this->property_model->get_all($product->id);
        $this->data['versions']			= $this->version_model->get_all($product->id);
		
		$this->data['links_list']		= $this->link_model->get_all(TRUE, $id);
			
        // form validation
        $this->form_validation->set_rules($this->product_model->init_validation_rules($product, $properties));
        if($this->form_validation->run() == FALSE)
        {
			$this->data['images']   = $product->get_images();
			
			// recover features data
			if(isset($_POST['product']['type_products_id']))
			{
				$product->type_products_id = $_POST['product']['type_products_id'];
				$product->set_groups_features($this->get_features_by_type_product_id($product->type_products_id));
			}
			
            // recover uploaded images on failed validation
            $this->_recover_post_image_data($product, 'products');
			
            $this->layout->view('products/product_form');
        }
        else 
        {
            // save and redirect
            $product_data		= $this->input->post('product');
            $content_data		= $this->input->post('content');
            $features_data		= $this->input->post('features');
            $image_data			= $this->input->post('image');
			$properties_data	= $this->input->post('properties');
			$links_data			= array(
									'links'			=> $this->input->post('links'), 
									'link_contents' => $this->input->post('link_contents')
								);
			$showcases_data		= $this->input->post('showcases');
			
			// let's save
            $product_id = $this->product_model->save($id, $product_data, $content_data, $image_data, $features_data, $properties_data, $links_data, $showcases_data);
            
            $this->set_message('success', 'Prodotto salvato con successo!');
			
			// and redirect
			$redirect = ($this->input->post('return')) ? 'admin/luoghi/inventario/aggiungi-versione/'. $product_id : 'admin/luoghi/inventario/'.$filter;
			redirect($redirect);
            
        }
        
    }
    
    

    
    
    public function delete($id, $filter = NULL)
    {
        $product = $this->product_model->get_product($id);
        
        if( ! $product)
        {
            $this->set_message('warning', 'Impossibile trovare il prodotto selezionato.');
            redirect('admin/luoghi/inventario/'.$filter);
        }
        else
        {
            $this->product_model->delete($product);
            $this->set_message('success', 'Prodotto eliminato con sucesso!');
            redirect('admin/luoghi/inventario/'.$filter);
        }
    }
}

?>
