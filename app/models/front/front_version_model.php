<?php
/**
 * Description of front_product_version_model
 *
 * @author alberto
 */
class Front_version_model extends MY_Model {
	
	private $table			= 'product_versions';
	private $table_contents = 'product_version_contents';
	private $table_features = 'product_version_features';
	private $table_images	= 'product_version_images';
	
	function __construct() {
		parent::__construct();
	}
	
	
	public function get_product_versions_as_list(Product $product)
	{
		$list = $this->db->get_where($this->table, array('product_id' => $product->id))->result('version');
		
		$return = array($product->get_route() => $product->get_content('name'));
		foreach($list as $item)
		{
			$item->set_content();
			$return[$item->get_route()] = $item->get_content('name'); 
		}
		
		return $return;
	}
	
	
	public function get_version_features($product_id, $version_id, $type_product_id)
	{
		$groups_list = $this->db->get_where('type_products_groups', array('type_products_id' => $type_product_id))->result();
		
		$groups = array();
		foreach($groups_list as $data)
		{
			$group = $this->db->get_where('groups_features', array('id' => $data->group_features_id))->row(0, 'group_features');

			$group->set_content();
			$group->set_features($this->get_group_features($group->id, $product_id, $version_id));
			
			$groups[] = $group;
		}
		
		return $groups;
	}
	
	public function get_group_features($group_id, $product_id, $version_id)
	{
		$features = $this->db->join('features', 'features.id = feature_groups.feature_id')
				->get_where('feature_groups', array('group_id' => $group_id))
				->result('feature');
		
		foreach($features as $feature)
		{
			$feature->set_version_content($this->get_feature_version_content($feature, $product_id, $version_id));
		}
		
		return $features;
	}
	
	public function get_feature_version_content($feature, $product_id, $version_id)
	{
		$content = $this->db->get_where('feature_contents', array('feature_id' => $feature->feature_id, 'iso' => $this->iso))->row(0, 'feature_content');

		$value = $this->db->get_where('product_features', 
					array(
						'feature_id'		=> $feature->feature_id,
						'group_features_id'	=> $feature->group_id,
						'product_id'		=> $product_id,
						'iso'				=> $this->iso
					))->row();
		
		$version_value = $this->_get_feature_version_content($feature, $version_id);
		
		if($version_value AND ! empty($version_value->value))
		{
			$value = $version_value;
		}
		
		$content->set_value($value);
		
		return $content;
	}
	
	private function _get_feature_version_content($feature, $version_id)
	{
		$value = $this->db->get_where('product_version_features', array(
				'feature_id'		=> $feature->feature_id,
				'group_features_id' => $feature->group_id,
				'version_id'		=> $version_id,
				'iso'				=> $this->iso
			))->row();
		
		return $value;
	}
	
	public function get($id)
	{
		$item = $this->db->get_where($this->table, array('id' => $id))->row(0, 'version');
		
		// set type product id from parent product
		$item->type_product_id = $this->db->get_where('products', array('id' => $item->product_id))->row()->type_products_id;
		
		if($item)
		{
			$item->set_content();
			$item->set_features();
			$item->set_images();
			$item->set_default_image();
			$item->set_links();
		}
		
		return $item;
	}
	
	
	public function get_content($version_id)
	{
		$content = $this->db->get_where('product_version_contents', array('version_id' => $version_id, 'iso' => $this->iso))->row(0, 'version_content');

		return $content;
	}
	
	public function get_images($version_id)
	{
		$images = $this->db->order_by('ord')
				->join('images', 'images.id = product_version_images.image_id')
                ->where('version_id', $version_id)
                ->get('product_version_images')
				->result('image');
        
		$return = array();
        foreach($images as $image)
        {
			$image->set_content();
			$return[$image->type][] = $image;
        }
        return $return;
	}
	
}

?>
