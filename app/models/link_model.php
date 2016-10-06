<?php
/**
 * Description of link_model
 *
 * @author alberto
 */
class Link_model extends MY_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    public function init_validation_rules($id)
    {
        $rules = array(
            array(
                'field' => 'link[name]',
                'label' => 'Nome Link',
                //'rules' => ($id) ? 'trim|required|is_unique[links_products.name.id.'.$id.']' : 'trim|required|is_unique[links_products.name]'
                'rules' => 'trim|required'
            )
        );
        return $rules;
    }

	
	public function get_all_for_version($version_id)
	{
		$links = $this->db->get('links')->result('link');
        
		foreach($links as $item)
		{
			$item->set_contents($this->get_contents_for_version($item->id, $version_id));
			
			$item->set_is_version_link($this->db->get_where('product_version_links', 
					array(
						'version_id'	=> $version_id,
						'link_id'		=> $item->id
					))->row()
			);

		}
			
        return $links;
	}

    public function get_all($set_contents = FALSE, $product_id = NULL)
    {
        $links = $this->db->get('links')->result('link');
        
		if($set_contents)
		{
			foreach($links as $item)
			{
				$item->set_contents($this->get_contents($item->id, $product_id));
			}
		}
		
		if($product_id)
		{
			foreach($links as $link)
			{
				$link->set_is_product_link($this->db->get_where('product_links', 
						array(
							'product_id'	=> $product_id,
							'link_id'		=> $link->id
						))->row()
				);
			}
		}
			
        return $links;
    }
   

    public function get_all_as_list($select = FALSE)
    {
        $groups = $this->db->get('links')->result();

        $list = ($select) ? array('Seleziona tipologia') : array();		
		foreach($groups as $group)
        {
            $list[$group->id] = $group->name;
        }
        return $list;
    }
    

    public function get_link($id)
    {
        $link = $this->db->get_where('links', array('id' => $id))->row(0, 'link');
        
        if ( ! $link)
            return FALSE;
		
		$link->set_contents($this->get_contents($link->id));
		
        return $link;
            
    }

	
	public function get_contents_for_version($link_id, $version_id)
	{
		$contents = $this->db->get_where('link_contents', array('link_id' => $link_id))->result('link_content');
		
		foreach($contents as $iso => $content) 
		{
			$version_values = $this->db->get_where('product_version_links', array('version_id' => $version_id, 'link_id' => $link_id, 'iso' => $iso))->row();
			if($version_values)
			{
				$content->label = $version_values->label;
				$content->href	= $version_values->href;
			}
		}
		
		return $contents;
	}
	
	
	
	public function get_contents($link_id, $product_id = FALSE)
	{
		$contents = $this->db->get_where('link_contents', array('link_id' => $link_id))->result('link_content');
		
		if($product_id)
		{
			foreach($contents as $iso => $content) 
			{
				$product_values = $this->db->get_where('product_links', array('product_id' => $product_id, 'link_id' => $link_id, 'iso' => $iso))->row();
				if($product_values)
				{
					$content->label = $product_values->label;
					$content->href	= $product_values->href;
				}
			}
		}
		
		return $contents;
	}
	
	private function _save_contents($link_id, $contents)
	{
		$this->db->delete('link_contents', array('link_id' => $link_id));
		
		$insert = array();
		foreach($contents as  $iso => $content)
		{
			$data = $content;
			$data['link_id']	= $link_id;
			$data['iso']			= $iso;
			$data['active']			= (isset($content['active'])) ? 1 : 0;
			
			$insert[]	= $data;
			$data		= array();
			
		}
		$this->db->insert_batch('link_contents', $insert);
	}
	
    
    public function delete($link)
    {
		// delete icon file
        if(file_exists($link->get_icon())) unlink($link->get_icon());
		
        $this->db->delete('links', array('id' => $link->id));
    }
    
    
    
    public function save($id, $link_data, $content_data)
    {
        if( ! $id)
        {
            $this->db->insert('links', $link_data);
            $id = $this->db->insert_id();
        }
        else
        {
            $this->db->where('id', $id)
                    ->update('links', $link_data);
        }

		$this->_save_contents($id, $content_data);
		
        return $id;
    }
    
    private function _clear_related($link_id)
	{
		$this->db->delete('link_groups', array('link_id' => $link_id));
	}
	
    private function _save_related($link_id, $related_data)
	{
		$this->_clear_related($link_id);
		
		if($related_data)
		{
			foreach($related_data as $entity => $entity_data)
			{
				foreach($entity_data as $group_id)
				{
					$data = array(
						'link_id'  => $link_id,
						'group_features_id'	=> $group_id
					);

					$this->db->insert('link_groups', $data);
				}
			}
		}
	}
}

?>
