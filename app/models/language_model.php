<?php
/**
 * Description of language_model
 *
 * @author Alberto
 */
class Language_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
	public function lang_exists($iso)
	{
		return (bool) $this->db->get_where('languages', array('iso' => $iso))->row();
	}
	
    public function get_languages($front = FALSE)
    {
		if($front) $this->db->where('active', 1);
		
        $langs_iso = $this->db->order_by('default', 'desc')->get('languages')->result('language');
        
		if($front) return $langs_iso;
		
        $languages = array();
        foreach($langs_iso as $language)
        {
            $languages[$language->iso] = strtolower($language->description);
        }
        return $languages;
    }
    
    public function get_default_language()
    {
        return $this->db->get_where('languages', array('default' => 1))->row(0, 'language');
    }
    
    public function get_language($iso)
    {
        return $this->db->get_where('languages', array('iso' => $iso))->row(0, 'language');
    }
	
	public function get_all($back = FALSE)
    {
        $this->db->order_by('default', 'desc');
		if( ! $back)
		{
			$this->db->where('active', 1);
		}
        return $this->db->get('languages')->result('language');
    }
	
	public function get($iso)
	{
		return ($iso) ? $this->db->get_where('languages', array('iso' => $iso))->row(0, 'language') : new Language();
	}
    
	
	public function update_language($iso, $item_data)
	{
		$item_data['default']	= (isset($item_data['default'])) ? 1 : 0;
		$item_data['active']	= (isset($item_data['active'])) ? 1 : 0;
		
		$this->db->where('iso', $iso);
		$this->db->update('languages', $item_data);
	}
	
	
	
	public function create_language($source_iso, $item_data)
	{
		$contents = array(
			'routed' => array(
				'category_contents',
				'news_contents',
				'page_contents',
				'product_contents',
				//'product_version_contents',
				'video_contents'
			),
			'simple' => array(
				'feature_contents',
				'group_features_contents',
				'image_contents',
				'link_contents',
				'property_contents' ,
				'text_contents',
				'product_features',
				'product_version_features'
			)
		);
		
		$item_data['default']	= (isset($item_data['default'])) ? 1 : 0;
		$item_data['active']	= (isset($item_data['active'])) ? 1 : 0;
		
		$this->db->trans_start();
		
		$this->db->insert('languages', $item_data);
				
		foreach($contents as $type => $tables)
		{
			$call = '_create_' . $type . '_contents';
			$this->$call($tables, $source_iso, $item_data['iso']);
		}
		
		$this->db->trans_complete();
	}
	
	private function _create_routed_contents($tables, $source_iso, $new_iso)
	{
		foreach($tables as $table)
		{
			$source_data = $this->db->get_where($table, array('iso' => $source_iso))->result();
			
			if(count($source_data) > 0)
			{
				$insert_batch = array();
				foreach($source_data as $table_row)
				{
					// get source iso route object
					$route = $this->route_model->get_route_by_id($table_row->route_id);

					// create new slug and set new route_id
					$new_slug = str_replace($source_iso.'/', $new_iso.'/', $route->slug);

					$table_row->route_id = $this->route_model->set_route($new_slug, $route->route);

					// set new iso
					$table_row->iso = $new_iso;

					// unset source id, duplicate entry prevent
					unset($table_row->id);

					$insert_batch[] = (array) $table_row;
				}

				$this->db->insert_batch($table, $insert_batch);
			}
		}
	}
	
	private function _create_simple_contents($tables, $source_iso, $new_iso)
	{
		
		foreach($tables as $table)
		{
			$source_data = $this->db->get_where($table, array('iso' => $source_iso))->result();
			
			if(count($source_data) > 0)
			{
				$insert_batch = array();
				foreach($source_data as $table_row)
				{
					// set new iso
					$table_row->iso = $new_iso;

					// unset source id, duplicate entry prevent
					unset($table_row->id);

					$insert_batch[] = (array) $table_row;
				}

				$this->db->insert_batch($table, $insert_batch);
			}
		}
	}
	
}

?>