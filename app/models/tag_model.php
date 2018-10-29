<?php
/**
 * Description of tag_model
 *
 * @author Alberto
 */
class Tag_model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }

    public function get_all()
    {
		$this->db->order_by('ord');
        return $this->db->get('tags')->result('tag');
    }
    
    public function get_all_as_list()
    {
        $list = $this->get_all();

        $options = [];
        foreach($list as $item) {
            $options[$item->id] = $item->name;
        }

        return $options;
    }


    public function get($id)
    {
        $tag = ($id) ? $this->db->get_where('tags', array('id' => $id))->row(0, 'tag') : new Video();
        
        return $tag;    
    }
    
    
    public function delete($tag)
    {
        foreach($tag->get_contents() as $content)
        {
			$this->db->where('id', $content->route_id);
            $this->db->update('routes', array('redirect' => base_url(), 'response_code' => 301));
        }
        
        $this->db->delete('tags', array('id' => $tag->id));
    }
    
    
    
    public function save($id)
    {
		$post_data		= $this->input->post();
		$tag_data		= $post_data['tag'];
		$content_data	= $post_data['content'];
		
		// $tag_data['published'] = (isset($tag_data['published'])) ? 1 : 0;
		// $tag_data['partner_id'] = $tag_data['partner_id'] ? $tag_data['partner_id'] : NULL;
		
        if( ! $id)
        {
            $this->db->insert('tags', $tag_data);
            $id = $this->db->insert_id();
            
			$this->_insert_contents($id, $content_data);
        }
        else
        {
            $this->db->where('id', $id)
                    ->update('tags', $tag_data);
			
			$this->_update_contents($id, $content_data);
        }
		
		
        
        return $id;
    }
    
    private function _insert_contents($tag_id, $contents)
    {
		$insert = array();
        {
            foreach($contents as $iso => $values)
            {
                $data               = $values;
                $data['iso']        = $iso;
                $data['tag_id']     = $tag_id;
                
                $insert[] = $data;
            }
        }
        $this->db->insert_batch('tag_contents', $insert);
    }
	
	private function _update_contents($tag_id, $contents)
	{
		foreach($contents as $iso => $values)
		{
			$data				= $values;
			$data['iso']        = $iso;
			$data['tag_id']   = $tag_id;
			$data['active']     = (isset($values['active'])) ? 1 : 0;

            // update content for the iso
            $this->db->where(array(
				'tag_id'	=> $tag_id, 
				'iso'		=> $iso));
            $this->db->update('tag_contents', $data);
		}
	}
    
    public function get_item_contents($tag_id)
    {
        $contents = $this->db->get_where('tag_contents', array('tag_id' => $tag_id))->result('tag_content');
        
        $return = array();
        foreach($contents as $content)
        {
            $return[$content->iso] = $content;
        }
        return $return;
    }

	public function sort()
	{
		foreach($this->input->post('tag') as $ord => $id)
		{
			$this->db->where('id', $id);
			$this->db->update('tags', array('ord' => $ord));
		}
	}
	
	
	public function init_validation_rules($id)
    {
        $rules = array(
            array(
                'field' => 'tag[name]',
                'label' => 'Nome tag',
                'rules' => ($id) ? 'trim|required|is_unique[tags.name.id.'.$id.']' : 'trim|required|is_unique[tags.name]'
            )
        );
        
        foreach($this->languages as $lang)
        {
            $content_rules = array(
                array(
                    'field' => 'content['.$lang->iso.'][label]',
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