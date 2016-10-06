<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of front_product_model
 *
 * @author alberto
 */
class Front_product_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function get($id)
	{
		$item = $this->db->get_where('products', array('id' => $id))->row(0, 'product');
		
		if( ! $item) return FALSE;
		
		//$item->set_content();
		//$item->set_default_image($this->front_image_model->get($item->default_image_id));
		$item->set_images($this->get_images($item->id));
		$item->set_properties($this->get_properties($item->id));
		$item->set_groups_features($this->front_feature_model->get_groups_features($item, 'product'));
		$item->set_links();

		return $item;
	}
	
	public function get_properties($product_id)
	{
		$properties = $this->db->order_by('ord')
				->join('properties', 'properties.id = product_properties.property_id')
                ->where('product_id', $product_id)
                ->get('product_properties')
				->result('property');
		
		foreach($properties as $property)
        {
			$property->set_content();
        }
		
		return $properties;
	}
	
	public function get_content($product_id)
	{
		$content = $this->db->get_where('product_contents', array('product_id' => $product_id, 'iso' => $this->iso))->row(0, 'product_content');

		return $content;
	}
	
	public function get_images($product_id)
	{
		$images = $this->db->order_by('ord')
				->join('images', 'images.id = product_images.image_id')
                ->where('product_id', $product_id)
                ->get('product_images')
				->result('image');
        
		$return = array();
        foreach($images as $image)
        {
			//$image->set_content();
			$return[$image->type][] = $image;
        }
        return $return;
	}
	
	
	public function get_latests($limit)
	{
		$this->db->where('published', 1);
		$this->db->order_by('created', 'desc');
		$this->db->limit($limit);
		return $this->db->get('products')->result('product');
	}
}

?>
