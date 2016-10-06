<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of front_link_model
 *
 * @author Alberto
 */
class Front_link_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	
	public function get_version_links(Version $version)
	{
		$links_id_list = $this->db->group_by('link_id')
				->order_by('ord', 'DESC')
				->get_where('product_version_links', array('version_id' => $version->id, 'iso' => $this->iso))
				->result('link');
		
		$list = array();
		foreach($links_id_list as $item)
		{
			$entity = array(
				'entity_table'		=> 'product_version_links', 
				'entity_field_id'	=> 'version_id', 
				'entity_data'		=> $version
			);
			$list[] = $this->get($item->link_id, $entity);
		}
		return $list;
	}
	
	
	public function get_product_links(Product $product)
	{
		$links_id_list = $this->db->group_by('link_id')
				->order_by('ord', 'DESC')
				->get_where('product_links', array('product_id' => $product->id, 'iso' => $this->iso))
				->result('link');
		
		$list = array();
		foreach($links_id_list as $item)
		{
			$entity = array(
				'entity_table'		=> 'product_links', 
				'entity_field_id'	=> 'product_id', 
				'entity_data'		=> $product
			);
			$list[] = $this->get($item->link_id, $entity);
		}
		return $list;
	}
	
	
	public function get_content($link_id, $entity = NULL)
	{
		$content = $this->db->get_where('link_contents', array('link_id' => $link_id, 'iso' => $this->iso))->row(0, 'link_content');

		// set entity data if entity is setted
		if($entity)
		{
			// get entity values
			$entity_values = $this->db->get_where($entity['entity_table'], array(
													$entity['entity_field_id']	=> $entity['entity_data']->id, 
													'iso'						=> $this->iso, 
													'link_id'					=> $link_id))
							->row();

			// set entity values
			if($entity_values)
			{
				$content->label = $entity_values->label;
				$content->href	= $entity_values->href;
			}
		}
		
		return $content;
	}
	
	public function get($id, $entity = NULL)
	{
		$link = $this->db->get_where('links', array('id' => $id))->row(0, 'link');
		
		if( ! $link)
			return FALSE;
		
		$link->set_content($entity);
		
		return $link;
	}
	
	
}

?>
