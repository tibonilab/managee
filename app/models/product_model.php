<?php
/**
 * Description of product_model
 *
 * @author Alberto
 */
class Product_model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }

    public function init_image_rules(Product $product)
    {
        // base image rules
        $rules = array(
            array(
                'field' => 'product[default_image_id]',
                'label' => 'Immagine predefinita',
                'rules' => 'required'
            )
        );
        
        // rules for uploaded images
        $images_id = (isset($_POST['image']['id'])) ? $_POST['image']['id'] : array();
        foreach($images_id as $image_id)
        {
            foreach($this->languages as $lang)
            {
                $image_rules = array(
                    array(
                        'field' => 'image[content]['.$image_id.']['.$lang->iso.'][title]',
                        'label' => '',
                        'rules' => ''
                    ),
                    array(
                        'field' => 'image[content]['.$image_id.']['.$lang->iso.'][description]',
                        'label' => '',
                        'rules' => ''
                    ),
					array(
						'field' => 'image['.$image_id.'][type]',
						'label' => '',
                        'rules' => ''
					)
                );
            
                $rules = array_merge($rules, $image_rules);
            }
        }
        
        // rules for product images
        foreach($product->get_images() as $image)
        {
            foreach($image->get_contents() as $iso => $content)
            {
                $setted_rules = array(
                    array(
                        'field' => 'image[content]['.$image->id.']['.$iso.'][title]',
                        'label' => '',
                        'rules' => ''
                    ),
                    array(
                        'field' => 'image[content]['.$image->id.']['.$iso.'][description]',
                        'label' => '',
                        'rules' => ''
                    )
                );

                $rules = array_merge($rules, $setted_rules);
            }
        }
         
        return $rules;
    }
    
    public function init_content_rules()
    {
        $rules = array();
        foreach($this->languages as $lang)
        {
            $content_rules = array(
                    array(
                        'field' => 'content['.$lang->iso.'][name]',
                        'label' => '',
                        'rules' => ''
                    ),
                    array(
                        'field' => 'content['.$lang->iso.'][description]',
                        'label' => '',
                        'rules' => ''
                    ),
                    array(
                        'field' => 'content['.$lang->iso.'][meta_title]',
                        'label' => '',
                        'rules' => ''
                    ),
                    array(
                        'field' => 'content['.$lang->iso.'][meta_key]',
                        'label' => '',
                        'rules' => ''
                    ),
                    array(
                        'field' => 'content['.$lang->iso.'][meta_descr]',
                        'label' => '',
                        'rules' => ''
                    ),
                    array(
                        'field' => 'content['.$lang->iso.'][active]',
                        'label' => '',
                        'rules' => ''
                    )
            );
            
            $rules = array_merge($rules, $content_rules);
        }
        return $rules;
    }
    
	public function init_properties_rules($properties)
	{
		$rules = array();
		
		foreach($properties as $property)
		{
			$properties_rules = array(
				array(
					'field' => 'properties['.$property->id.']',
					'label' => '',
					'rules' => ''
				)
			);
			
			$rules = array_merge($rules, $properties_rules);
		}
		
		return $rules;
	}
	
	public function init_features_rules(Product $product)
	{
		$rules = array();
		
		if (isset($_POST['product']['type_products_id']))
		{
			$product->type_products_id = $_POST['product']['type_products_id'];
		}
		
		foreach($this->type_model->get_related_groups($product->type_products_id, FALSE) as $group_features)
		{
			foreach($group_features->get_features() as $feature)
			{
				foreach($feature->get_contents() as $iso => $content)
				{
					$features_rules = array(
						array(
							'field' => 'features['.$iso.']['.$feature->feature_id.'][value]',
							'label' => '',
							'rules' => ''
						)
					);

					$rules = array_merge($rules, $features_rules);
				}
			}
		}		
		
		return $rules;
	}
	
	
    public function init_validation_rules(Product $product, $properties = NULL)
    {
        $rules = array(
            array(
                'field' => 'product[name]',
                'label' => 'Nome Prodotto',
                'rules' => ($product->id) ? 'trim|required|is_unique[products.name.id.'.$product->id.']' : 'trim|required|is_unique[products.name]'
            ),
            array(
                'field' => 'product[category_id]',
                'label' => 'Categoria di appartenenza',
                'rules' => ''
            ),
            /*            array(
                'field' => 'product[code]',
                'label' => 'Codice Prodotto',
                'rules' => ($product->id) ? 'trim|required|is_unique[products.code.id.'.$product->id.']' : 'trim|required|is_unique[products.code]'
            ),
			array(
					'field' => 'product[price]',
                'label' => 'Prezzo',
                'rules' => 'numeric'
            ),
            array(
                'field' => 'product[sale_price]',
                'label' => 'Prezzo vendita',
                'rules' => 'numeric'
            ),
            array(
                'field' => 'product[weight]',
                'label' => 'Peso',
                'rules' => 'numeric'
            ),*/
            
            array(
                'field' => 'product[type_products_id]',
                'label' => 'Tipologia prodotto',
                'rules' => ''//'is_natural_no_zero'
            ),
            array(
                'field' => 'product[published]',
                'label' => '',
                'rules' => ''
            )
        );
        
        // base content rules
        $rules = array_merge($rules, $this->init_content_rules());
        
        // setted and uploaded images rules
        $rules = array_merge($rules, $this->init_image_rules($product));
        
		// properties rules
		$rules = array_merge($rules, $this->init_properties_rules($properties));
		
		// features rules
		$rules = array_merge($rules, $this->init_features_rules($product));
		
        $this->form_validation->set_message('is_natural_no_zero', 'E\' necessario selezionare: %s');
        
        return $rules;
    }
    
    
    public function get_all($filter = NULL)
    {
		if($filter)
		{
			$this->db->order_by('ord');
			$this->db->where('category_id', $filter);
		}
		else
		{
			$this->db->order_by('code, name');
		}
		
        $products = $this->db->get('products')->result('product');
        
        foreach($products as $product)
        {
			$product->set_contents($this->_get_product_contents($product->id));
            if($product->category_id) $product->set_category($this->category_model->get_category($product->category_id));
            $product->set_default_image($this->image_model->get_image($product->default_image_id));
        }
		
        return $products;
    }
    
    
    public function get_product($id)
    {
        $product = $this->db->get_where('products', array('id' => $id))->row(0, 'product');
        
        if ( ! $product)
            return FALSE;
        
        $product->set_contents($this->_get_product_contents($product->id));
        $product->set_images($this->_get_product_images($product->id));
        $product->set_default_image($this->image_model->get_image($product->default_image_id));
        $product->set_groups_features($this->_get_features_values($product));
		
        return $product;
            
    }
    
	private function _get_features_values(Product $product)
	{
		$groups_features = $this->type_model->get_related_groups($product->type_products_id, FALSE, $product->id);
		
		return $groups_features;
	}
    
    public function delete($product)
    {
        foreach($product->get_contents() as $content)
        {
			$this->db->where('id', $content->route_id);
            $this->db->update('routes', array('redirect' => base_url(), 'response_code' => 301));
        }
        
        $this->db->delete('products', array('id' => $product->id));
    }
	
    public function save($id, $product_data, $content_data, $image_data, $features_data, $properties_data, $links_data, $showcases_data)
    {	
		$product_data['published']	= (isset($product_data['published'])) ? 1 : 0;
		$product_data['is_new']		= (isset($product_data['is_new'])) ? 1 : 0;
		$product_data['category_id']	= (isset($product_data['category_id']) AND $product_data['category_id']) ? $product_data['category_id'] : NULL;
		
        if( ! $id)
        {
            $this->db->insert('products', $product_data);
            $id = $this->db->insert_id();
            
            $this->_insert_contents($id, $content_data);
        }
        else
        {
            $this->db->where('id', $id)
                    ->update('products', $product_data);
            
            $this->_update_contents($id, $content_data);
        }
        
		// related data
        $this->_save_images($id, $image_data);
		$this->_save_properties($id, $properties_data);
		$this->_save_features($id, $features_data);
		$this->_save_links($id, $links_data);
        $this->_save_showcases($id, $showcases_data);
		$this->_save_videos($id);
		
        return $id;
    }

	
	private function _save_showcases($product_id, $showcases_data)
    {
        // reset properties associations
        $this->db->delete('showcase_products', array('product_id' => $product_id));
		
		if(is_array($showcases_data))
		{
			$insert_batch = array();
			{
				foreach($showcases_data as $showcase_id)
				{
				   $insert_batch[] = array (
					   'product_id'		=> $product_id,
					   'showcase_id'	=> $showcase_id,
					   'ord'			=> 0
				   );
				}
			}

			$this->db->insert_batch('showcase_products', $insert_batch);  
		}
    }
	
	
	
	
	private function _save_links($product_id, $links_data)
	{
        // reset properties associations
        $this->db->delete('product_links', array('product_id' => $product_id));

		if(is_array($links_data['links']))
		{
			$insert_batch = array();
			foreach($links_data['links'] as $ord => $link_id)
			{
				foreach($links_data['link_contents'][$link_id] as $iso => $link_contents)
				{
					$insert_batch[] = array (
						'product_id'	=> $product_id,
						'link_id'		=> $link_id,
						'iso'			=> $iso,
						'label'			=> $link_contents['label'],
						'href'			=> $link_contents['href'],
						'ord'			=> $ord
				   );
				}
			}
			$this->db->insert_batch('product_links', $insert_batch);  
		}
    }
	
	
	private function _save_properties($product_id, $properties_data)
    {
        // reset properties associations
        $this->db->delete('product_properties', array('product_id' => $product_id));
		
		if(is_array($properties_data))
		{
			$insert_batch = array();
			{
				foreach($properties_data as $property_id => $true)
				{
				   $insert_batch[] = array (
					   'product_id'		=> $product_id,
					   'property_id'	=> $property_id,
					   //'ord'			=> $ord
				   );
				}
			}

			$this->db->insert_batch('product_properties', $insert_batch);  
		}
    }
	
    
    private function _save_images($product_id, $images)
    {
        // reset image associations
        $this->db->delete('product_images', array('product_id' => $product_id));
        
        // images associations
        $insert_batch = array();
        {
            foreach($images['id'] as $ord => $image_id)
            {
               $insert_batch[] = array (
                   'product_id' => $product_id,
                   'image_id'   => $image_id,
                   'ord'        => $ord,
				   'type'		=> $images[$image_id]['type']
               );
            }
        }
		$this->db->insert_batch('product_images', $insert_batch);
        
        // save image contents
        $this->load->model('image_model');
        foreach($images['content'] as $image_id => $contents)
        {
            $this->image_model->update_contents($image_id, $contents);
        }
        
    }
	
	
	private function _save_videos($product_id)
	{
		$this->db->delete('product_videos', array('product_id' => $product_id));
		
		$list = $this->input->post('video_list');
		
		if($list)
		{
			$insert_batch = array();
			
			
			
			foreach($list as $ord => $video_id)
			{
				$insert_batch[] = array(
					'product_id'	=> $product_id,
					'video_id'		=> $video_id,
					'ord'			=> $ord,
					'is_default'	=> $this->input->post('default_video') == $video_id ? 1 : 0
				);
			}
			
			$this->db->insert_batch('product_videos', $insert_batch);
		}
	}
    
     
    
    
    private function _update_contents($product_id, $contents)
    {
        foreach($contents as $iso => $data)
        {
            // update slug
			$paths = explode('/', str_replace($iso . '/', '', $data['slug']));
			
			foreach($paths as $path)
			{
				$path = url_title($path, '-', TRUE);
			}
			$slug = implode('/', $paths);
			
			$data['slug'] = str_replace($iso . '/', '', $data['slug']);
			
			$slug		= $iso . '/';
            $slug       .= (empty($data['slug'])) ? url_title($data['name'], '-', TRUE) : url_title($data['slug'], '-', TRUE);
            
			$route_id   = $this->_get_route_id($product_id, $iso);
            
            $data['route_id']	= $this->route_model->update_slug($route_id, $slug);

			$data['active']     = (isset($data['active'])) ? $data['active'] : 0;
            unset($data['slug']);

            // update content for the iso
            $this->db->where(array('product_id' => $product_id, 'iso' => $iso))
                    ->update('product_contents', $data);
        }
    }
    
    private function _get_route_id($product_id, $iso)
    {
        return $this->db->get_where('product_contents', array('product_id' => $product_id, 'iso' => $iso))->row()->route_id;
    }

    
    private function _insert_features($product_id, $features)
    {
		$insert = array();
        foreach($features as $iso => $feature_data)
        {
			foreach($feature_data as $feature_id => $data)
			{
				$insert[] = array(
					'product_id'		=> $product_id,
					'feature_id'		=> $feature_id,
					'group_features_id' => $data['group_features_id'],
					'iso'				=> $iso,
					'value'				=> $data['value']
				);
			}
        } 
        $this->db->insert_batch('product_features', $insert);
    }

    private function _save_features($product_id, $features)
    {
		$this->db->delete('product_features', array('product_id' => $product_id));
		
		if(is_array($features))
		{
			$this->_insert_features($product_id, $features);
		}
    }
    
    private function _insert_contents($product_id, $contents)
    {
        $insert = array();
        {
            foreach($contents as $iso => $values)
            {
                $data               = $values;
                $data['iso']        = $iso;
                $data['product_id'] = $product_id;
                $data['active']     = (isset($values['active'])) ? $values['active'] : 0;
                
                // slug generation
				$values['slug'] = str_replace($iso . '/', '', $values['slug']);
				
                $slug	= $iso . '/';
				$slug	.= (empty($values['slug'])) ? url_title($values['name'], '-', TRUE) : url_title($values['slug'], '-', TRUE);
                $data['route_id']   = $this->route_model->set_route($slug, 'front/products/show/' . $product_id);
                unset($data['slug']);
                
                $insert[] = $data;
            }
        }
        $this->db->insert_batch('product_contents', $insert);
    }

    
    private function _get_product_contents($product_id)
    {
        $contents = $this->db->get_where('product_contents', array('product_id' => $product_id))->result('product_content');
        
        $return = array();
        foreach($contents as $content)
        {
            $content->set_slug($this->route_model->get_slug_by_id($content->route_id));
            $return[$content->iso] = $content;
        }
        return $return;
    }
    
    private function _get_image_type($image_id, $product_id)
	{
		return $this->db->get_where('product_images', array('image_id' => $image_id, 'product_id' => $product_id))->row()->type;
	}

		
    public function get_product_images($product_id)
    {
        $records = $this->db->order_by('ord')
                ->where('product_id', $product_id)
                ->get('product_images')->result();
        
        $images = array();
        foreach($records as $record)
        {
			$image = $this->image_model->get_image($record->image_id);
			$image->set_type($this->_get_image_type($image->id, $product_id));
			
            $images[] = $image;
        }
        return $images;
    }
	
	public function get_product_videos($product_id)
	{
		
		$this->db->order_by('product_videos.ord');
		$this->db->where('product_id', $product_id);
		$this->db->join('videos', 'videos.id = product_videos.video_id');
		return $this->db->get('product_videos')->result('video');
	}
	
    private function _get_product_images($product_id)
    {
        $records = $this->db->order_by('ord')
                ->where('product_id', $product_id)
                ->get('product_images')->result();
        
        $images = array();
        foreach($records as $record)
        {
			$image = $this->image_model->get_image($record->image_id);
			$image->set_type($this->_get_image_type($image->id, $product_id));
			
            $images[] = $image;
        }
        return $images;
    }
	
	
	public function sort()
	{
		foreach($this->input->post('product') as $ord => $id)
		{
			$this->db->where('id', $id);
			$this->db->update('products', array('ord' => $ord));
		}
	}
}

?>
