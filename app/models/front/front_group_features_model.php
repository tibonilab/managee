<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of front_group_features_model
 *
 * @author Alberto
 */
class Front_group_features_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function get_content($group_features_id)
	{
		$content = $this->db->get_where('group_features_contents', array('group_features_id' => $group_features_id, 'iso' => $this->iso))->row(0, 'group_features_content');

		return $content;
	}
	
	public function get($id)
	{
		$group_features = $this->db->get_where('group_featuress', array('id' => $id))->row(0, 'group_features');
		
		if( ! $group_features)
			return FALSE;
		
		$group_features->set_content();
		
		return $group_features;
	}
	
	
}

?>
