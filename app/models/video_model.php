<?php
/**
 * Description of video_model
 *
 * @author Alberto
 */
class Video_model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }

	public function get_all_related_id($product_id)
	{
		// get all $product_id related video
		$this->db->where('product_id', $product_id);
		$list = $this->db->get('product_videos')->result();
		
		// init return array
		$return = array();
		
		// create set_value() helper array
        foreach($list as $record)
		{
			$return[] = $record->video_id;
		}
		
		// return related videos id array
		return $return;
	}
	
    public function get_all()
    {
		$this->db->order_by('ord');
        return $this->db->get('videos')->result('video');
    }
    
    
    public function get($id)
    {
        $video = ($id) ? $this->db->get_where('videos', array('id' => $id))->row(0, 'video') : new Video();
        
        return $video;    
    }
    
    
    public function delete($video)
    {
        foreach($video->get_contents() as $content)
        {
			$this->db->where('id', $content->route_id);
            $this->db->update('routes', array('redirect' => base_url(), 'response_code' => 301));
        }
        
        $this->db->delete('videos', array('id' => $video->id));
    }
    
    
    
    public function save($id)
    {
		$post_data		= $this->input->post();
		$video_data		= $post_data['video'];
		$content_data	= $post_data['content'];
		
		$video_data['published'] = (isset($video_data['published'])) ? 1 : 0;
		$video_data['partner_id'] = $video_data['partner_id'] ? $video_data['partner_id'] : NULL;
		
        if( ! $id)
        {
            $this->db->insert('videos', $video_data);
            $id = $this->db->insert_id();
            
			$this->_insert_contents($id, $content_data);
        }
        else
        {
            $this->db->where('id', $id)
                    ->update('videos', $video_data);
			
			$this->_update_contents($id, $content_data);
        }
		
		
        
        return $id;
    }
    
    
    
    private function _get_route_id($video_id, $iso)
    {
        return $this->db->get_where('video_contents', array('video_id' => $video_id, 'iso' => $iso))->row()->route_id;
    }
    
    
    
    private function _insert_contents($video_id, $contents)
    {
		$insert = array();
        {
            foreach($contents as $iso => $values)
            {
                $data               = $values;
                $data['iso']        = $iso;
                $data['video_id']   = $video_id;
                $data['active']     = (isset($values['active'])) ? 1 : 0;
                
                // slug generation
				$values['slug'] = str_replace($iso . '/', '', $values['slug']);
				
                $slug	= $iso . '/';
				$slug	.= (empty($values['slug'])) ? url_title($values['title'], '-', TRUE) : url_title($values['slug'], '-', TRUE);
                $data['route_id']   = $this->route_model->set_route($slug, 'front/videos/show/' . $video_id);
                unset($data['slug']);
                
                $insert[] = $data;
            }
        }
        $this->db->insert_batch('video_contents', $insert);
    }
	
	private function _update_contents($video_id, $contents)
	{
		foreach($contents as $iso => $values)
		{
			$data				= $values;
			$data['iso']        = $iso;
			$data['video_id']   = $video_id;
			$data['active']     = (isset($values['active'])) ? 1 : 0;

			$data['slug'] = str_replace($iso . '/', '', $data['slug']);

			$slug		= $iso . '/';
			$slug       .= (empty($data['slug'])) ? url_title($data['title'], '-', TRUE) : url_title($data['slug'], '-', TRUE);
			$route_id   = $this->_get_route_id($video_id, $iso);
			
			$data['route_id']	= $this->route_model->update_slug($route_id, $slug);
			
			unset($data['slug']);

            // update content for the iso
            $this->db->where(array(
				'video_id'	=> $video_id, 
				'iso'		=> $iso));
            $this->db->update('video_contents', $data);
		}
	}
	
	
	public function get_item_contents($video_id)
    {
        $contents = $this->db->get_where('video_contents', array('video_id' => $video_id))->result('video_content');
        
        $return = array();
        foreach($contents as $content)
        {
            $return[$content->iso] = $content;
        }
        return $return;
    }
	
	
	public function sort()
	{
		foreach($this->input->post('video') as $ord => $id)
		{
			$this->db->where('id', $id);
			$this->db->update('videos', array('ord' => $ord));
		}
	}
	
	
	public function init_validation_rules($id)
    {
        $rules = array(
            array(
                'field' => 'video[name]',
                'label' => 'Nome video',
                'rules' => ($id) ? 'trim|required|is_unique[videos.name.id.'.$id.']' : 'trim|required|is_unique[videos.name]'
            ),
			array(
                'field' => 'video[url]',
                'label' => 'URL video',
                'rules' => ($id) ? 'trim|required|is_unique[videos.url.id.'.$id.']' : 'trim|required|is_unique[videos.url]'
            ),
            array(
                'field' => 'video[published]',
                'label' => '',
                'rules' => ''
            ),
            array(
                'field' => 'video[channel]',
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
                        'field' => 'content['.$lang->iso.'][content]',
                        'label' => '',
                        'rules' => ''
                    ),
	                array(
                        'field' => 'content['.$lang->iso.'][slug]',
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
	
}

?>