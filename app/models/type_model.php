<?php
/**
 * Description of type_model
 *
 * @author alberto
 */
class Type_model extends MY_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    public function init_validation_rules($id)
    {
        $rules = array(
            array(
                'field' => 'type_products[name]',
                'label' => 'Tipologia prodotto',
                //'rules' => ($id) ? 'trim|required|is_unique[types_products.name.id.'.$id.']' : 'trim|required|is_unique[types_products.name]'
                'rules' => 'trim|required'
            )
        );
        return $rules;
    }


    public function get_all()
    {
        $types = $this->db->get('types_products')->result('type');
        
        return $types;
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
    
	
    public function get_all_as_list($select = FALSE)
    {
        $groups = $this->db->get('types_products')->result();

        $list = ($select) ? array('Seleziona tipologia') : array();		
		foreach($groups as $group)
        {
            $list[$group->id] = $group->name;
        }
        return $list;
    }
    
    
	public function get_related_groups($type_products_id, $as_list = TRUE, $product_id = FALSE)
	{
        if($as_list)
        {
            $groups_id = $this->db->get_where('type_products_groups', array('type_products_id' => $type_products_id))->result();

            $list = array();
            foreach($groups_id as $data)
            {
                $list[] = $data->group_features_id;
            }

            return $list;
        }
        else
        {
            $groups = $this->db->join('groups_features', 'groups_features.id = type_products_groups.group_features_id')
                    ->get_where('type_products_groups', array('type_products_id' => $type_products_id))->result('group_features');
            
            //echo $this->db->last_query();
            
            // load features
            foreach($groups as $group)
            {
                $group->set_features($this->get_features_by_group_id($group->group_features_id, $product_id));
            }
            
            return $groups;
        }
	}

    
	public function get_group_by_group_id($group_id, $type_product_id)
	{
		$group = $this->db->get_where('groups_features', array('id' => $group_id))->row(0, 'group_features');
		
		if ( ! $group )  return FALSE;
		
		$group->set_features($this->get_features_by_group_id($group->id, FALSE, $type_product_id));
		
		return $group;
	}
	
	
    public function get_features_by_group_id($group_id, $product_id = FALSE, $type_product_id = FALSE)
    {
        $features = $this->db->join('features', 'features.id = feature_groups.feature_id')
				->order_by('ord, type')
                ->get_where('feature_groups', array('group_id' => $group_id))->result('feature');
        
        //echo $this->db->last_query();
        
        foreach($features as $feature)
        {
            $feature->set_contents($this->_get_feature_contents($feature, $product_id));
			
			if($type_product_id)
			{
				$feature->is_versionable = (bool) $this->db->get_where('versionable_features', 
						array(
							'type_product_id'	=> $type_product_id,
							'group_features_id'	=> $group_id,
							'feature_id'		=> $feature->id
						))->row();
			}
        }
        
        return $features;
    }
    
    private function _get_feature_contents(Feature $feature, $product_id = FALSE)
    {
        $contents = $this->db->get_where('feature_contents', array('feature_id' => $feature->feature_id))
				->result('feature_content');
        
		//echo $this->db->last_query() . '<br><br>';

		if($product_id)
		{
			
			foreach($contents as $feature_content)
			{
				$value = $this->db->get_where('product_features', array('product_id' => $product_id, 'group_features_id' => $feature->group_id, 'feature_id' => $feature->feature_id, 'iso' => $feature_content->iso))->row();

				$feature_content->set_value($value);
				
				//echo $this->db->last_query() . '<br><br>';
			}
		}
		
        $return = array();
        foreach($contents as $content)
        {
            $return[$content->iso] = $content;
        }
		
		//var_dump($return);
        return $return;
    }
    
    
    public function get_type($id)
    {
        $type = $this->db->get_where('types_products', array('id' => $id))->row(0, 'type');
        
        if ( ! $type)
            return FALSE;
        
        return $type;
            
    }
    
    
    public function delete($type)
    {
        $this->db->delete('types_products', array('id' => $type->id));
    }
    
    
    
    public function save($id, $type_data, $related_data, $version_data)
    {
        if( ! $id)
        {
            $this->db->insert('types_products', $type_data);
            $id = $this->db->insert_id();
        }
        else
        {
            $this->db->where('id', $id)
                    ->update('types_products', $type_data);
        }

		$this->_save_related($id, $related_data);
		$this->_save_versionable_features($id, $version_data);
		
        return $id;
    }
    
	private function _save_versionable_features($type_products_id, $version_data)
	{	
		$this->db->delete('versionable_features', 
				array(
					'type_product_id'	=> $type_products_id,
				));
		
		if(is_array($version_data))
		{
			$insert = array();
			foreach($version_data as $group_id => $features_id)
			{
				foreach($features_id as $feature_id)
				$insert[] = array(
					'type_product_id'	=> $type_products_id,
					'group_features_id'	=> $group_id,
					'feature_id'		=> $feature_id
				);

			}

			$this->db->insert_batch('versionable_features', $insert);
		}
	}
	
    private function _clear_related($type_products_id)
	{
		$this->db->delete('type_products_groups', array('type_products_id' => $type_products_id));
	}
	
    private function _save_related($type_products_id, $related_data)
	{
		$this->_clear_related($type_products_id);
		
		if($related_data)
		{
			foreach($related_data as $entity => $entity_data)
			{
				foreach($entity_data as $group_id)
				{
					$data = array(
						'type_products_id'  => $type_products_id,
						'group_features_id'	=> $group_id
					);

					$this->db->insert('type_products_groups', $data);
				}
			}
		}
	}
}

?>
