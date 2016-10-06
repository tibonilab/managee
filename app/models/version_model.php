<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of version_model
 *
 * @author alberto
 */
class Version_model extends MY_Model {
	//put your code here
	
	function __construct() {
		parent::__construct();
	}
	
	
	
	public function get_all($product_id)
	{
		$versions = $this->db->get_where('product_versions', array('product_id' => $product_id))->result('version');
		
		foreach($versions as $version)
		{
			$version->set_contents($this->_get_version_contents($version->id));
		}
		
		return $versions;
	}
	
	
	
	public function get($version_id, Product $product)
	{
		$version = $this->db->get_where('product_versions', array('id' => $version_id))->row(0, 'version');
		
		if( ! $version) return FALSE;
		
		$version->type_product_id = $product->type_products_id;
		
		$version->set_contents($this->_get_version_contents($version->id));
		$version->set_images($this->_get_version_images($version->id));
		$version->set_groups_features($this->get_features_values($version->type_product_id, $version->id));
		
		return $version;
	}
	
	
	public function get_for_delete($id)
	{
		$item = $this->db->get_where('product_versions', array('id' => $id))->row(0, 'version');
		
		if($item)
		{
			$item->set_contents($this->_get_version_contents($item->id));
		}
		
		return $item;
	}
	
	
	public function init_image_rules(Version $version)
    {
        // base image rules
        $rules = array(
            array(
                'field' => 'version[default_image_id]',
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
                    )
                );
            
                $rules = array_merge($rules, $image_rules);
            }
        }
        
        // rules for product images
        foreach($version->get_images() as $image)
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

	
	public function init_features_rules(Version $version)
	{
		$rules = array();
		
		foreach($version->get_groups_features() as $group_features)
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
	
	
    public function init_validation_rules(Version $version)
    {
        $rules = array(
            array(
                'field' => 'version[name]',
                'label' => 'Nome Versione',
                'rules' => ($version->id) ? 'trim|required|is_unique[products.name.id.'.$version->id.']' : 'trim|required|is_unique[products.name]'
            ),
            array(
                'field' => 'version[code]',
                'label' => 'Codice Versione',
                'rules' => ($version->id) ? 'trim|required|is_unique[products.code.id.'.$version->id.']' : 'trim|required|is_unique[products.code]'
            ),            
            array(
                'field' => 'version[published]',
                'label' => '',
                'rules' => ''
            )
        );
        
        // base content rules
        $rules = array_merge($rules, $this->init_content_rules());
        
        // setted and uploaded images rules
        $rules = array_merge($rules, $this->init_image_rules($version));
		
		// features rules
		$rules = array_merge($rules, $this->init_features_rules($version));
		
        $this->form_validation->set_message('is_natural_no_zero', 'E\' necessario selezionare: %s');
        
        return $rules;
    }
    
	
	
	public function get_features_values($type_product_id, $version_id = FALSE)
	{	
		$groups_features = $this->db->group_by('group_features_id')
				->join('groups_features', 'groups_features.id = versionable_features.group_features_id')
				->get_where('versionable_features', array('type_product_id' => $type_product_id))->result('group_features');
		
		//echo $this->db->last_query();
		
		foreach($groups_features as $group_features)
		{
			$group_features->set_features($this->_get_versionable_features($type_product_id, $group_features->group_features_id, $version_id));
		}
		
		return $groups_features;
	}
    
	
	
	private function _get_versionable_features($type_product_id, $group_features_id, $version_id = FALSE)
	{
		$versionable_features = $this->db->join('features', 'features.id = versionable_features.feature_id')
				->get_where('versionable_features', 
				array(
					'group_features_id' => $group_features_id,
					'type_product_id'	=> $type_product_id))
				->result('feature');
		
		foreach($versionable_features as $feature)
		{
			$feature->set_contents($this->_get_feature_contents($feature, $version_id));			
		}
		
		return $versionable_features;
	}
	
	
	
	private function _get_feature_contents($feature, $version_id = FALSE)
	{
		$contents = $this->db->get_where('feature_contents', array('feature_id' => $feature->id))->result('feature_content');
		
		// grabbing values for Version $version_id
		if($version_id)
		{
			foreach($contents as $feature_content)
			{
				$value = $this->db->get_where('product_version_features', 
						array(
							'feature_id'		=> $feature->feature_id,
							'group_features_id'	=> $feature->group_features_id,
							'version_id'		=> $version_id,
							'iso'				=> $feature_content->iso
						))->row();

				$feature_content->set_value($value);
			}
		}

		$return = array();
        foreach($contents as $feature_content)
        {
            $return[$feature_content->iso] = $feature_content;
        }
        return $return;
	}
	
	
	
    public function delete(Version $version)
    {
        foreach($version->get_contents() as $content)
        {
			$this->db->where('id', $content->route_id);
            $this->db->update('routes', array('redirect' => base_url(), 'response_code' => 301));
        }
        
        $this->db->delete('product_versions', array('id' => $version->id));
    }
	
	
	
    public function save($id, $version_data, $content_data, $image_data, $features_data, $links_data)
    {	
		$version_data['published'] = (isset($version_data['published'])) ? 1 : 0;
		
        if( ! $id)
        {
            $this->db->insert('product_versions', $version_data);
            $id = $this->db->insert_id();
            
            $this->_insert_contents($id, $content_data);
        }
        else
        {
            $this->db->where('id', $id)
                    ->update('product_versions', $version_data);
            
            $this->_update_contents($id, $content_data);
        }
        
		// related data
        $this->_save_images($id, $image_data);
		$this->_save_features($id, $features_data);
		$this->_save_links($id, $links_data);
        
        return $id;
    }
	
	
	
	private function _save_links($version_id, $links_data)
	{
        // reset properties associations
        $this->db->delete('product_version_links', array('version_id' => $version_id));
		
		if(is_array($links_data['links']))
		{
			$insert_batch = array();
			foreach($links_data['links'] as $ord => $link_id)
			{
				foreach($links_data['link_contents'][$link_id] as $iso => $link_contents)
				{
					$insert_batch[] = array (
						'version_id'	=> $version_id,
						'link_id'		=> $link_id,
						'iso'			=> $iso,
						'label'			=> $link_contents['label'],
						'href'			=> $link_contents['href'],
						'ord'			=> $ord
				   );
				}
			}
			$this->db->insert_batch('product_version_links', $insert_batch);  
		}
    }
	
	
    private function _save_images($version_id, $images)
    {
        // reset image associations
        $this->db->delete('product_version_images', array('version_id' => $version_id));
        
        // images associations
        $insert_batch = array();
        {
            foreach($images['id'] as $ord => $image_id)
            {
               $insert_batch[] = array (
                   'version_id' => $version_id,
                   'image_id'   => $image_id,
                   'ord'        => $ord,
				   'type'		=> $images[$image_id]['type']
               );
            }
        }
        $this->db->insert_batch('product_version_images', $insert_batch);
        
        // save image contents
        $this->load->model('image_model');
        foreach($images['content'] as $image_id => $contents)
        {
            $this->image_model->update_contents($image_id, $contents);
        }
        
    }
    
    
	
	
    private function _update_contents($version_id, $contents)
    {
        foreach($contents as $iso => $data)
        {
            // update slug
			/*$data['slug'] = str_replace($iso . '/', '', $data['slug']);
			
            $slug	= $iso . '/';
			$slug	.= (empty($data['slug'])) ? url_title($data['name'], '-', TRUE) : url_title($data['slug'], '-', TRUE);
            $route_id   = $this->_get_route_id($version_id, $iso);
            
            $this->route_model->update_slug($route_id, $slug);

			$data['active']     = (isset($data['active'])) ? $data['active'] : 0;*/
            unset($data['slug']);

            // update content for the iso
            $this->db->where(array('version_id' => $version_id, 'iso' => $iso))
                    ->update('product_version_contents', $data);
        }
    }
    
	
	
	
    private function _get_route_id($version_id, $iso)
    {
        return $this->db->get_where('product_version_contents', array('version_id' => $version_id, 'iso' => $iso))->row()->route_id;
    }

    
	
	
    private function _insert_features($version_id, $features)
    {
		$insert = array();
        foreach($features as $iso => $feature_data)
        {
			foreach($feature_data as $feature_id => $data)
			{
				$insert[] = array(
					'version_id'		=> $version_id,
					'feature_id'		=> $feature_id,
					'group_features_id' => $data['group_features_id'],
					'iso'				=> $iso,
					'value'				=> $data['value']
				);
			}
        } 
        $this->db->insert_batch('product_version_features', $insert);
    }

	
	
    private function _save_features($version_id, $features)
    {
		$this->db->delete('product_version_features', array('version_id' => $version_id));
		
		if(is_array($features))
		{
			$this->_insert_features($version_id, $features);
		}
    }
    
	
	
	
    private function _insert_contents($version_id, $contents)
    {
        $insert = array();
        {
            foreach($contents as $iso => $values)
            {
                $data               = $values;
                $data['iso']        = $iso;
                $data['version_id']    = $version_id;
                $data['active']     = (isset($values['active'])) ? $values['active'] : 0;
                
                /*/* slug generation
				$values['slug'] = str_replace($iso . '/', '', $values['slug']);
				
                $slug	= $iso . '/';
				$slug	.= (empty($values['slug'])) ? url_title($values['name'], '-', TRUE) : url_title($values['slug'], '-', TRUE);
                $data['route_id']   = $this->route_model->set_route($slug, 'front/versions/show/' . $version_id); */
                unset($data['slug']);
                
                $insert[] = $data;
            }
        }
        $this->db->insert_batch('product_version_contents', $insert);
    }

    
	
	
    private function _get_version_contents($version_id)
    {
        $contents = $this->db->get_where('product_version_contents', array('version_id' => $version_id))->result('version_content');
        
        $return = array();
        foreach($contents as $content)
        {
            $content->set_slug($this->route_model->get_slug_by_id($content->route_id));
            $return[$content->iso] = $content;
        }
        return $return;
    }
    
    
	
	
    private function _get_version_images($version_id)
    {
        $records = $this->db->order_by('ord')
                ->where('version_id', $version_id)
                ->get('product_version_images')->result();
        
        $images = array();
        foreach($records as $record)
        {
            $image = $this->image_model->get_image($record->image_id);
			$image->set_type($this->_get_image_type($image->id, $version_id));
			
			$images[] = $image;
        }
        return $images;
    }
	
	
	
	private function _get_image_type($image_id, $version_id)
	{
		return $this->db->get_where('product_version_images', array('image_id' => $image_id, 'version_id' => $version_id))->row()->type;
	}
	
}

?>
