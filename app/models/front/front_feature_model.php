<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of front_feature_model
 *
 * @author Alberto
 */
class Front_feature_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function get_content(Feature $feature, $entity, $entity_type)
	{
		$content = $this->db->get_where('feature_contents', array('feature_id' => $feature->feature_id, 'iso' => $this->iso))->row(0, 'feature_content');
		
		if($entity)
		{
			$value = $this->db->get_where('product_features', 
						array(
							'feature_id'		=> $feature->feature_id,
							'group_features_id'	=> $feature->group_id,
							'product_id'		=> $entity->id,
							'iso'				=> $this->iso
						))->row();
			$content->set_value($value);
		}
		
		return $content;
	}
	
	public function get($id, $entity = NULL, $entity_type = NULL)
	{
		$feature = $this->db->get_where('features', array('id' => $id))->row(0, 'feature');
		
		if( ! $feature)
			return FALSE;
		
		$feature->set_content();
		
		return $feature;
	}
	
	public function get_groups_features($entity, $entity_type)
	{
		$groups = $this->db->join('groups_features', 'groups_features.id = type_products_groups.group_features_id')
				->get_where('type_products_groups', array('type_products_id' => $entity->type_products_id))
				->result('group_features');
		
		foreach($groups as $group)
		{
			$group->set_content();
			$group->set_features($this->get_features($group, $entity, $entity_type));
		}
		
		return $groups;
	}
	
	
	public function get_features(Group_features $group, $entity, $entity_type)
	{
		$features = $this->db->join('features', 'features.id = feature_groups.feature_id')
				->get_where('feature_groups', array('group_id' => $group->id))
				->result('feature');
		
		foreach($features as $feature)
		{
			$feature->set_content($entity, $entity_type);
		}
		
		return $features;
	}
	
	
}

?>
