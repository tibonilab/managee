<?php
/**
 * Description of feature_model
 *
 * @author Alberto
 */
class Feature_model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    
        public function init_validation_rules($id)
    {
        $rules = array(
            array(
                'field' => 'feature[name]',
                'label' => 'Nome caratteristica',
                //'rules' => ($id) ? 'trim|required|is_unique[features.name.id.'.$id.']' : 'trim|required|is_unique[features.name]'
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'feature[parent_id]',
                'label' => '',
                'rules' => ''
            ),
            array(
                'field' => 'feature[visible]',
                'label' => '',
                'rules' => ''
            )
        );
        
        foreach($this->languages as $lang)
        {
            $content_rules = array(
                    array(
                        'field' => 'content['.$lang->iso.'][name]',
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
    
    
    public function get_groups_as_list()
    {
        $groups = $this->db->get('groups_features')->result();

        $list = array();		
		foreach($groups as $group)
        {
            $list[$group->id] = $group->name;
        }
        return $list;
    }
    
	
	
	public function get_related_groups($feature_id)
	{
		$groups_id = $this->db->get_where('feature_groups', array('feature_id' => $feature_id))->result();
		
		$list = array();
		foreach($groups_id as $data)
		{
			$list[] = $data->group_id;
		}

		return $list;
	}
	
    /**
     * Recursive features option list tree extract
     * 
     * @access private
     * @param array $features array of Category object records
     * @param string $spacer indentation string
     * @param array $list partial option list extracted
     * @return array partial option list extracted
    
    private function _get_all_as_list($features, $spacer, $list)
    {
        $spacer .= '>>';
        foreach($features as $feature)
        {
            $list[$feature->id] = $spacer .' '. $feature->name;
            
            if($feature->is_branch())
            {
                $list = $this->_get_all_as_list($feature->get_childs(), $spacer, $list);
            }   
        }
        return $list;
    } */
    
    /**
     * Recursive features tree extract
     * 
     * @access public
     * @param int|string $parent_id
     * @return array array of Category object records
     */
    public function get_all()
    {
        $features = $this->db->get('features')->result('feature');

        foreach($features as $feature)
        {
            $feature->set_contents($this->_get_feature_contents($feature->id));
        }
        
        return $features;
    }
    
    
    
    public function get_feature($id)
    {
        $feature = $this->db->get_where('features', array('id' => $id))->row(0, 'feature');
        
        if ( ! $feature)
            return FALSE;
        
        $feature->set_contents($this->_get_feature_contents($feature->id));
        
        return $feature;
            
    }
    
    
    public function delete($feature)
    {
        $this->db->delete('features', array('id' => $feature->id));
    }
    
    
    
    public function save($id, $feature_data, $content_data, $related_data)
    {
        if( ! $id)
        {
            $this->db->insert('features', $feature_data);
            $id = $this->db->insert_id();
            
            $this->_insert_contents($id, $content_data);
        }
        else
        {
            $this->db->where('id', $id)
                    ->update('features', $feature_data);
            
            $this->_update_contents($id, $content_data);
        }

		$this->_save_related($id, $related_data);
		
        return $id;
    }
    
    private function _clear_related($feature_id)
	{
		$this->db->delete('feature_groups', array('feature_id' => $feature_id));
	}
	
    private function _save_related($feature_id, $related_data)
	{
		$this->_clear_related($feature_id);
		
		if($related_data)
		{
			foreach($related_data as $entity => $entity_data)
			{
				foreach($entity_data as $group_id)
				{
					$data = array(
						'feature_id' => $feature_id,
						'group_id'	 => $group_id
					);

					$this->db->insert('feature_groups', $data);
				}
			}
		}
	}
    
    
    private function _update_contents($feature_id, $contents)
    {
        foreach($contents as $iso => $data)
        {
            $data['active']	= (isset($data['active'])) ? $data['active'] : 0;
            
            // update content for the iso
            $this->db->where(array('feature_id' => $feature_id, 'iso' => $iso))
                    ->update('feature_contents', $data);
        }
    }
    

    private function _insert_contents($feature_id, $contents)
    {
        $insert = array();
        {
            foreach($contents as $iso => $values)
            {
                $data                   = $values;
                $data['iso']            = $iso;
                $data['feature_id']		= $feature_id;
                $data['active']         = (isset($values['active'])) ? $values['active'] : 0;
                
                $insert[] = $data;
            }
        }
        $this->db->insert_batch('feature_contents', $insert);
    }

    
    private function _get_feature_contents($feature_id)
    {
        $contents = $this->db->get_where('feature_contents', array('feature_id' => $feature_id))->result('feature_content');
        
        $return = array();
        foreach($contents as $content)
        {
            $return[$content->iso] = $content;
        }
        return $return;
    }
  
}
?>
