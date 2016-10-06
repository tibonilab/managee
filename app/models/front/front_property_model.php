<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of front_property_model
 *
 * @author Alberto
 */
class Front_property_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function get_content($property_id)
	{
		$content = $this->db->get_where('property_contents', array('property_id' => $property_id, 'iso' => $this->iso))->row(0, 'property_content');

		return $content;
	}
	
	public function get($id)
	{
		$property = $this->db->get_where('properties', array('id' => $id))->row(0, 'property');
		
		if( ! $property)
			return FALSE;
		
		$property->set_content();
		
		return $property;
	}
	
	
}

?>
