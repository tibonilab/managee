<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of front_showcase_model
 *
 * @author Alberto
 */
class Front_showcase_model extends MY_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	public function get($id)
	{
		return $this->db->get_where('showcases', array('id' => $id))->row(0, 'showcase');
	}
	
	public function get_default_showcase()
	{
		return $this->db->get_where('showcases', array('default' => 1))->row(0, 'showcase');
	}
	
	public function get_content($showcase_id)
	{
		$this->db->where('showcase_id', $showcase_id);
		$this->db->where('iso', $this->iso);
		return $this->db->get('showcase_contents')->row(0, 'showcase_content');
	}
	
	public function get_showcase_images($showcase_id)
	{
		$this->db->join('images i', 'i.id = si.image_id');
		$this->db->order_by('si.ord');
		$this->db->where('si.showcase_id', $showcase_id);
		return $this->db->get('showcase_images si')->result('image');
	}
	
	public function get_showcase_feateured_products($showcase_id, $limit = NULL, $rand = FALSE)
	{
		if($limit)
		{
			$this->db->limit($limit);
		}
		
		if($rand)
			$this->db->order_by('sp.ord', 'random');
		else
			$this->db->order_by('sp.ord');
		
		$this->db->join('products p', 'sp.product_id = p.id');
		$this->db->group_by('p.created', 'desc');
		$this->db->where('showcase_id', $showcase_id);
		return $this->db->get('showcase_products sp')->result('product');
	}
}

?>