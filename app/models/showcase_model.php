<?php

/**
 * Description of showcase_model
 *
 * @author Alberto
 */
class Showcase_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function get_all($as_list = FALSE)
	{
		$showcases = $this->db->get('showcases')->result('showcase');
		
		if($as_list)
		{
			$list = array('Nessuna vetrina');
			foreach($showcases as $showcase)
			{
				$list[$showcase->id] = $showcase->name;
			}
			return $list;
		}
		
		return $showcases;
	}
	
	public function get($id)
	{
		if( ! $id) return new Showcase();
		
		return $this->db->get_where('showcases', array('id' => $id))->row(0, 'showcase');
	}
	
	public function get_images($showcase_id)
	{
		$this->db->join('images i', 'i.id = si.image_id');
		$this->db->order_by('si.ord');
		$this->db->where('si.showcase_id', $showcase_id);
		return $this->db->get('showcase_images si')->result('image');
	}
	
	
	public function get_featured_products($showcase_id)
	{
		$this->db->join('products p', 'sp.product_id = p.id');
		$this->db->group_by('p.id');
		$this->db->order_by('sp.ord');
		$this->db->where('showcase_id', $showcase_id);
		return $this->db->get('showcase_products sp')->result('product');
	}
	
	public function save_featured($id, $data, $products)
	{
		$data['featured'] = 1;
		
		if( ! $id)
		{
			$this->db->insert('showcases', $data);
			$id = $this->db->insert_id();
		}
		else 
		{
			$this->db->where('id', $id);
			$this->db->update('showcases', $data);
		}
		
		$this->_save_featured_order($id, $products);
		
		return $id;
	}
	
	
	private function _save_featured_order($id, $products)
	{
		$this->db->delete('showcase_products', array('showcase_id' => $id));
		
		if(is_array($products))
		{
			$insert_batch = array();
			foreach($products as $ord => $product_id)
			{
				$insert_batch[] = array(
					'showcase_id'	=> $id,
					'product_id'	=> $product_id,
					'ord'			=> $ord
				);
			}
			$this->db->insert_batch('showcase_products', $insert_batch);
		}
	}
	
	public function save($id, $data, $images, $contents)
	{
		$data['featured'] = 0;
		
		if( ! $id)
		{
			$this->db->insert('showcases', $data);
			$id = $this->db->insert_id();
			
			$this->_insert_contents($id, $contents);
		}
		else 
		{
			$this->db->where('id', $id);
			$this->db->update('showcases', $data);
			
			$this->_update_contents($id, $contents);
		}
		
		$this->_save_images($id, $images);
		
		return $id;
	}
	
	
	private function _save_images($showcase_id, $images)
	{
		$this->db->delete('showcase_images', array('showcase_id' => $showcase_id));
		
		if(is_array($images))
		{
			$insert = array();
			foreach($images['id'] as $ord => $image_id)
			{
				$insert[] = array(
					'showcase_id'	=> $showcase_id,
					'image_id'		=> $image_id,
					'ord'			=> $ord
				);
			}

			$this->db->insert_batch('showcase_images', $insert);

			foreach($images['content'] as $image_id => $contents)
			{
				$this->image_model->update_contents($image_id, $contents);
			}
		}
	}
	
	    private function _update_contents($showcase_id, $contents)
    {
        foreach($contents as $iso => $data)
        {
            // update slug
			$data['slug'] = str_replace($iso . '/', '', $data['slug']);
			
            $slug		= $iso . '/';
			$slug		.= (empty($data['slug'])) ? url_title($data['title'], '-', TRUE) : url_title($data['slug'], '-', TRUE);
            $route_id   = $this->_get_route_id($showcase_id, $iso);
            
            $data['route_id']	= $this->route_model->update_slug($route_id, $slug);
            $data['active']     = (isset($data['active'])) ? $data['active'] : 0;

			unset($data['slug']);
            
            // update content for the iso
            $this->db->where(array('showcase_id' => $showcase_id, 'iso' => $iso))
                    ->update('showcase_contents', $data);
        }
    }
    
    private function _get_route_id($showcase_id, $iso)
    {
        return $this->db->get_where('showcase_contents', array('showcase_id' => $showcase_id, 'iso' => $iso))->row()->route_id;
    }
    
    
    
    private function _insert_contents($showcase_id, $contents)
    {
        $insert = array();
        {
            foreach($contents as $iso => $values)
            {
                $data               = $values;
                $data['iso']        = $iso;
                $data['showcase_id']    = $showcase_id;
                $data['active']     = (isset($values['active'])) ? $values['active'] : 0;
                
                // slug generation
				$values['slug'] = str_replace($iso . '/', '', $values['slug']);
				
                $slug	= $iso . '/';
				$slug	.= (empty($values['slug'])) ? url_title($values['title'], '-', TRUE) : url_title($values['slug'], '-', TRUE);
                $data['route_id']   = $this->route_model->set_route($slug, 'front/showcases/show/' . $showcase_id);
                unset($data['slug']);
                
                $insert[] = $data;
            }
        }
        $this->db->insert_batch('showcase_contents', $insert);
    }

    
    public function get_showcase_contents($showcase_id)
    {
        $contents = $this->db->get_where('showcase_contents', array('showcase_id' => $showcase_id))->result('showcase_content');
        
        $return = array();
        foreach($contents as $content)
        {
            $content->set_slug($this->route_model->get_slug_by_id($content->route_id));
            $return[$content->iso] = $content;
        }
        return $return;
    }

	
	public function delete(Showcase $showcase)
	{
		$this->load->model('image_model');
		
		// delete showcase images for not featured showcases
		if( ! $showcase->is_featured())
		{
			foreach($showcase->get_images() as $image)
			{
				$this->image_model->delete($image);
			}
		}
		
		return $this->db->delete('showcases', array('id' => $showcase->id));
	}
	
	
	public function init_images_rules(Showcase $showcase)
	{
        // base image rules
        $rules = array(
            array(
                'field' => 'showcase[default_image_id]',
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
        
        // rules for showcase images
        foreach($showcase->get_images() as $image)
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
	
	public function init_validation_rules(Showcase $showcase)
	{
		$rules = array(
			array(
				'field' => 'showcase[name]',
				'label' => 'Nome Vetrina',
				'rules' => ($showcase->id) ? 'trim|required|is_uique[showcases.name.id.'.$showcase->id.']' : 'trim|required|is_uique[showcases.name]'
			),
		);
		
		foreach($this->languages as $lang)
        {
            $content_rules = array(
                    array(
                        'field' => 'content['.$lang->iso.'][title]',
                        'label' => 'Contenuti: Titolo',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'content['.$lang->iso.'][content]',
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
		
		// add images rules only if showcase is not featured.
		if( ! $showcase->is_featured())
		{
			$rules = array_merge($rules, $this->init_images_rules($showcase));
		}
		
		
		return $rules;
	}
}

?>
