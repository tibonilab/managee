<?php
/**
 * Description of property_model
 *
 * @author alberto
 */
class Property_model extends MY_Model{
    
    function __construct() {
        parent::__construct();
    }
    
    public function init_validation_rules($id)
    {
        $rules = array(
            array(
                'field' => 'property[name]',
                'label' => 'Nome Prorpietà',
                //'rules' => ($id) ? 'trim|required|is_unique[properties_products.name.id.'.$id.']' : 'trim|required|is_unique[properties_products.name]'
                'rules' => 'trim|required'
            )
        );
        return $rules;
    }


    public function get_all($product_id = NULL)
    {
        $properties = $this->db->get('properties')->result('property');
        
		foreach($properties as $property)
		{
			$property->set_contents($this->get_contents($property->id));
		}
		
		if($product_id)
		{
			foreach($properties as $property)
			{
				$property->set_is_product_property($this->db->get_where('product_properties', 
						array(
							'product_id'	=> $product_id,
							'property_id'	=> $property->id
						))->row()
				);
			}
		}
			
        return $properties;
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
        $groups = $this->db->get('properties')->result();

        $list = ($select) ? array('Seleziona tipologia') : array();		
		foreach($groups as $group)
        {
            $list[$group->id] = $group->name;
        }
        return $list;
    }
    
    
	public function get_related_groups($property_id, $as_list = TRUE, $product_id = FALSE)
	{
        if($as_list)
        {
            $groups_id = $this->db->get_where('property_groups', array('property_id' => $property_id))->result();

            $list = array();
            foreach($groups_id as $data)
            {
                $list[] = $data->group_features_id;
            }

            return $list;
        }
        else
        {
            $groups = $this->db->join('groups_features', 'groups_features.id = property_groups.group_features_id')
                    ->get_where('property_groups', array('property_id' => $property_id))->result('group_features');
            
            //echo $this->db->last_query();
            
            // load features
            foreach($groups as $group)
            {
                $group->set_features($this->get_features_by_group_id($group->group_features_id, $product_id));
            }
            
            return $groups;
        }
	}

    
    public function get_features_by_group_id($group_id, $product_id = FALSE)
    {
        $features = $this->db->join('features', 'features.id = feature_groups.feature_id')
                ->get_where('feature_groups', array('group_id' => $group_id))->result('feature');
        
        //echo $this->db->last_query();
        
        foreach($features as $feature)
        {
            $feature->set_contents($this->_get_feature_contents($feature, $product_id));
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
    
    /*
    public function get_all()
    {
        $properties_products = $this->db->get('properties')->result('property');

        foreach($properties_products as $property)
        {
            $property->set_contents($this->_get_feature_contents($property->id));
        }
        
        return $properties_products;
    }*/
    
    
    
    public function get_property($id)
    {
        $property = $this->db->get_where('properties', array('id' => $id))->row(0, 'property');
        
        if ( ! $property)
            return FALSE;
		
		$property->set_contents($this->get_contents($property->id));
		
        return $property;
            
    }
    
	public function get_contents($property_id)
	{
		$contents = $this->db->get_where('property_contents', array('property_id' => $property_id))->result('property_content');
		
		//echo $this->db->last_query();
		
		//var_dump($contents);
		
		return $contents;
	}
	
	private function _save_contents($property_id, $contents)
	{
		$this->db->delete('property_contents', array('property_id' => $property_id));
		
		$insert = array();
		foreach($contents as  $iso => $content)
		{
			$data = $content;
			$data['property_id']	= $property_id;
			$data['iso']			= $iso;
			$data['active']			= (isset($content['active'])) ? 1 : 0;
			
			$insert[]	= $data;
			$data		= array();
			
		}
		$this->db->insert_batch('property_contents', $insert);
	}
	
    
    public function delete($property)
    {
		// delete icon file
        if(file_exists($property->get_icon())) unlink($property->get_icon());
		
        $this->db->delete('properties', array('id' => $property->id));
    }
    
    
    
    public function save($id, $property_data, $content_data)
    {
        if( ! $id)
        {
            $this->db->insert('properties', $property_data);
            $id = $this->db->insert_id();
        }
        else
        {
            $this->db->where('id', $id)
                    ->update('properties', $property_data);
        }

		$this->_save_contents($id, $content_data);
		
        return $id;
    }
    
    private function _clear_related($property_id)
	{
		$this->db->delete('property_groups', array('property_id' => $property_id));
	}
	
    private function _save_related($property_id, $related_data)
	{
		$this->_clear_related($property_id);
		
		if($related_data)
		{
			foreach($related_data as $entity => $entity_data)
			{
				foreach($entity_data as $group_id)
				{
					$data = array(
						'property_id'  => $property_id,
						'group_features_id'	=> $group_id
					);

					$this->db->insert('property_groups', $data);
				}
			}
		}
	}
}

?>
