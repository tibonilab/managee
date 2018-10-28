<?php
/**
 * Description of page_model
 *
 * @author Alberto
 */
class Page_model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }

    public function init_validation_rules($id)
    {
        $rules = array(
            array(
                'field' => 'page[name]',
                'label' => 'Nome pagina',
                'rules' => ($id) ? 'trim|required|is_unique[pages.name.id.'.$id.']' : 'trim|required|is_unique[pages.name]'
            ),
            array(
                'field' => 'page[published]',
                'label' => '',
                'rules' => ''
            )
        );
        
        foreach($this->languages as $lang)
        {
            $content_rules = array(
                    array(
                        'field' => 'content['.$lang->iso.'][title]',
                        'label' => '',
                        'rules' => ''
                    ),
                    array(
                        'field' => 'content['.$lang->iso.'][subtitle]',
                        'label' => '',
                        'rules' => ''
                    ),
					array(
                        'field' => 'content['.$lang->iso.'][list]',
                        'label' => '',
                        'rules' => ''
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
        
        return $rules;
    }
    
    public function get_all()
    {
		if($this->input->get('key'))
		{
			$this->db->where('name LIKE "%'.$this->input->get('key').'%"');
		}
		
        $page = $this->db->get('pages')->result('page');
        
        foreach($page as $item)
        {
            $item->set_contents($this->_get_page_contents($item->id));
        }
        
        return $page;
    }
    
    
    public function get_page($id)
    {
        $page = $this->db->get_where('pages', array('id' => $id))->row(0, 'page');
        
        if ( ! $page)
            return FALSE;
        
        $page->set_contents($this->_get_page_contents($page->id));
        
        return $page;
            
    }
    
    
    public function delete($page)
    {
        foreach($page->get_contents() as $content)
        {
			$this->db->where('id', $content->route_id);
            $this->db->update('routes', array('redirect' => base_url(), 'response_code' => 301));
        }
        
        $this->db->delete('pages', array('id' => $page->id));
    }
    
    
    
    public function save($id, $page_data, $content_data, $image_data = NULL)
    {
		$page_data['published'] = (isset($page_data['published'])) ? $page_data['published'] : 0;
		$page_data['is_homepage'] = (isset($page_data['is_homepage'])) ? $page_data['is_homepage'] : 0;
		$page_data['category_id'] = (isset($page_data['category_id']) AND $page_data['category_id']) ? $page_data['category_id'] : NULL;
		$page_data['showcase_id'] = (isset($page_data['showcase_id']) AND $page_data['showcase_id']) ? $page_data['showcase_id'] : NULL;
		
		
        if( ! $id)
        {
            $this->db->insert('pages', $page_data);
            $id = $this->db->insert_id();
            
            $this->_insert_contents($id, $content_data);
        }
        else
        {
            $this->db->where('id', $id)
                    ->update('pages', $page_data);
            
            $this->_update_contents($id, $content_data);
        }
		
		$this->_save_images($id, $image_data);
        $this->_save_attachments($id);
        $this->_save_tags($id);
		
        return $id;
    }
    
    private function _save_tags($page_id) 
    {
        $this->db->delete('page_tags', ['page_id' => $page_id]);

        $tags = $this->input->post('tags');
        
        if($tags) 
        {
            $batch_data = [];
    
            foreach($tags as $tag_id)
            {
                $batch_data[] = [
                    'page_id' => $page_id,
                    'tag_id' => $tag_id
                ];
            }

            $this->db->insert_batch('page_tags', $batch_data);
        }

    }

    
    private function _save_attachments($page_id)
    {
		$attachments = $this->input->post('attachment');
		
		if(is_array($attachments))
		{
			// reset attachment associations
			$this->db->delete('page_attachments', array('page_id' => $page_id));

			if(is_array($attachments))
			{
				// attachments associations
				$insert_batch = array();
				{
					foreach($attachments['id'] as $ord => $attachment_id)
					{
					   $insert_batch[] = array (
						   'page_id'		=> $page_id,
						   'attachment_id'  => $attachment_id,
						   'ord'			=> $ord
					   );
					}
				}
				$this->db->insert_batch('page_attachments', $insert_batch);

				// save attachment contents
				$this->load->model('attachment_model');
				foreach($attachments['content'] as $attachment_id => $contents)
				{
					$this->attachment_model->update_contents($attachment_id, $contents);
				}
			}
		}
        
    }      
    
    private function _save_images($page_id, $images)
    {
        // reset image associations
        $this->db->delete('page_images', array('page_id' => $page_id));
        
		if (is_array($images))
		{
			// images associations
			$insert_batch = array();
			{
				foreach($images['id'] as $ord => $image_id)
				{
				   $insert_batch[] = array (
					   'page_id' => $page_id,
					   'image_id'   => $image_id,
					   'ord'        => $ord,
					   //'type'		=> $images[$image_id]['type']
				   );
				}
			}
			$this->db->insert_batch('page_images', $insert_batch);

			// save image contents
			$this->load->model('image_model');
			foreach($images['content'] as $image_id => $contents)
			{
				$this->image_model->update_contents($image_id, $contents);
			}
		}
        
    }
    
    private function _update_contents($page_id, $contents)
    {
        foreach($contents as $iso => $data)
        {
            // update slug
			$data['slug'] = str_replace($iso . '/', '', $data['slug']);
			
            $slug		= $iso . '/';
			$slug		.= (empty($data['slug'])) ? url_title($data['title'], '-', TRUE) : url_title($data['slug'], '-', TRUE);
            $route_id   = $this->_get_route_id($page_id, $iso);
            
            $data['route_id']	= $this->route_model->update_slug($route_id, $slug);
            $data['active']     = (isset($data['active'])) ? $data['active'] : 0;

			unset($data['slug']);
            
            // update content for the iso
            $this->db->where(array('page_id' => $page_id, 'iso' => $iso))
                    ->update('page_contents', $data);
        }
    }
    
    private function _get_route_id($page_id, $iso)
    {
        return $this->db->get_where('page_contents', array('page_id' => $page_id, 'iso' => $iso))->row()->route_id;
    }
    
    
    
    private function _insert_contents($page_id, $contents)
    {
        $insert = array();
        {
            foreach($contents as $iso => $values)
            {
                $data               = $values;
                $data['iso']        = $iso;
                $data['page_id']    = $page_id;
                $data['active']     = (isset($values['active'])) ? $values['active'] : 0;
                
                // slug generation
				$values['slug'] = str_replace($iso . '/', '', $values['slug']);
				
                $slug	= $iso . '/';
				$slug	.= (empty($values['slug'])) ? url_title($values['title'], '-', TRUE) : url_title($values['slug'], '-', TRUE);
                $data['route_id']   = $this->route_model->set_route($slug, 'front/pages/show/' . $page_id);
                unset($data['slug']);
                
                $insert[] = $data;
            }
        }
        $this->db->insert_batch('page_contents', $insert);
    }

    
    private function _get_page_contents($page_id)
    {
        $contents = $this->db->get_where('page_contents', array('page_id' => $page_id))->result('page_content');
        
        $return = array();
        foreach($contents as $content)
        {
            $content->set_slug($this->route_model->get_slug_by_id($content->route_id));
            $return[$content->iso] = $content;
        }
        return $return;
    }
	
	public function get_images($page_id)
    {
        $records = $this->db->order_by('ord')
                ->where('page_id', $page_id)
                ->get('page_images')->result();
        
        $images = array();
        foreach($records as $record)
        {
			$image = $this->image_model->get_image($record->image_id);
			//$image->set_type($this->_get_image_type($image->id, $page_id));
			
            $images[] = $image;
        }
        return $images;
    }
	
	private function _get_image_type($image_id, $page_id)
	{
		return $this->db->get_where('page_images', array('image_id' => $image_id, 'page_id' => $page_id))->row()->type;
	}
}

?>
