<?php
/**
 * Description of category_model
 *
 * @author Alberto
 */
class Category_model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    
	public function init_image_rules(Category $category)
    {
        // base image rules
        $rules = array(
            array(
                'field' => 'category[default_image_id]',
                'label' => 'Immagine predefinita',
                'rules' => ''
            )
        );
        
        // rules for uploaded images
        $images_id = (isset($_POST['image']['id'])) ? $_POST['image']['id'] : array();
        foreach($images_id as $image_id)
        {
            foreach($this->languages as $lang)
            {
                $image_rules = array(
                    array(
                        'field' => 'image[content]['.$image_id.']['.$lang->iso.'][title]',
                        'label' => '',
                        'rules' => ''
                    ),
                    array(
                        'field' => 'image[content]['.$image_id.']['.$lang->iso.'][description]',
                        'label' => '',
                        'rules' => ''
                    )
                );
            
                $rules = array_merge($rules, $image_rules);
            }
        }
        
        // rules for product images
        foreach($category->get_images() as $image)
        {
            foreach($image->get_contents() as $iso => $content)
            {
                $setted_rules = array(
                    array(
                        'field' => 'image[content]['.$image->id.']['.$iso.'][title]',
                        'label' => '',
                        'rules' => ''
                    ),
                    array(
                        'field' => 'image[content]['.$image->id.']['.$iso.'][description]',
                        'label' => '',
                        'rules' => ''
                    )
                );

                $rules = array_merge($rules, $setted_rules);
            }
        }
         
        return $rules;
    }
	
	
	
        public function init_validation_rules(Category $category)
    {
        $rules = array(
            array(
                'field' => 'category[name]',
                'label' => 'Nome Categoria',
                //'rules' => ($id) ? 'trim|required|is_unique[categories.name.id.'.$id.']' : 'trim|required|is_unique[categories.name]'
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'category[parent_id]',
                'label' => '',
                'rules' => ''
            ),
            array(
                'field' => 'category[published]',
                'label' => '',
                'rules' => ''
            )
        );
        
        foreach($this->languages as $lang)
        {
            $content_rules = array(
                    array(
                        'field' => 'content['.$lang->iso.'][name]',
                        'label' => '',
                        'rules' => ''
                    ),
		            array(
                        'field' => 'content['.$lang->iso.'][description]',
                        'label' => '',
                        'rules' => ''
                    ),
                    array(
                        'field' => 'content['.$lang->iso.'][meta_title]',
                        'label' => '',
                        'rules' => ''
                    ),
                    array(
                        'field' => 'content['.$lang->iso.'][meta_key]',
                        'label' => '',
                        'rules' => ''
                    ),
                    array(
                        'field' => 'content['.$lang->iso.'][meta_descr]',
                        'label' => '',
                        'rules' => ''
                    ),
                    array(
                        'field' => 'content['.$lang->iso.'][active]',
                        'label' => '',
                        'rules' => ''
                    )
            );
            
            $rules = array_merge($rules, $content_rules);
        }
        
		$rules = array_merge($rules, $this->init_image_rules($category));
		
        return $rules;
    }
    
    
    public function get_all_as_list($module = 'products')
    {
        $categories = $this->get_all(0, $module);

        $list = array();
        $list = $this->_get_all_as_list($categories, '', $list);

        return $list;
    }
    
    /**
     * Recursive categories option list tree extract
     * 
     * @access private
     * @param array $categories array of Category object records
     * @param string $spacer indentation string
     * @param array $list partial option list extracted
     * @return array partial option list extracted
     */
    private function _get_all_as_list($categories, $spacer, $list)
    {
        $spacer .= '. . ';
        foreach($categories as $category)
        {
            $list[$category->id] = $spacer .' '. $category->name;
            
            if($category->is_branch())
            {
                $list = $this->_get_all_as_list($category->get_childs(), $spacer, $list);
            }   
        }
        return $list;
    }
    
    /**
     * Recursive categories tree extract
     * 
     * @access public
     * @param int|string $parent_id
     * @return array array of Category object records
     */
    public function get_all($parent_id = 0, $module = 'products')
    {
		$this->db->where('module', $module);
		
        $categories = $this->db->order_by('ord')->get_where('categories', array('parent_id' => $parent_id))->result('category');
        
        foreach($categories as $category)
        {
            $category->set_childs($this->get_all($category->id, $module));
			$category->set_default_image($this->image_model->get_image($category->default_image_id));
        }
        
        return $categories;
    }
    
    
    
    public function get_category($id)
    {
        $category = $this->db->get_where('categories', array('id' => $id))->row(0, 'category');
        
        if ( ! $category)
            return FALSE;
        
        $category->set_contents($this->_get_category_contents($category->id));
        $category->set_images($this->_get_category_images($category->id));
		
        return $category;
            
    }
    
    
    public function delete($category)
    {
        foreach($category->get_contents() as $content)
        {
			$this->db->where('id', $content->route_id);
            $this->db->update('routes', array('redirect' => base_url(), 'response_code' => 301));
        }
        
        $this->db->delete('categories', array('id' => $category->id));
    }
    
    
    
    public function save($id, $category_data, $content_data, $image_data)
    {
		$category_data['published'] = (isset($category_data['published'])) ? 1 : 0;
		
        if( ! $id)
        {
            $this->db->insert('categories', $category_data);
            $id = $this->db->insert_id();
            
            $this->_insert_contents($id, $content_data);
        }
        else
        {
            $this->db->where('id', $id)
                    ->update('categories', $category_data);
            
            $this->_update_contents($id, $content_data);
        }
        
		$this->_save_images($id, $image_data);
		
        return $id;
    }
    
    
	private function _save_images($category_id, $image_data)
	{
		$this->db->delete('category_images', array('category_id' => $category_id));
		
		if(is_array($image_data))
		{
			$insert = array();
			foreach($image_data['id'] as $ord => $image_id)
			{
				$insert[] = array(
					'category_id'	=> $category_id,
					'image_id'		=> $image_id,
					'ord'			=> $ord
				);
			}
			
			$this->db->insert_batch('category_images', $insert);
		}
		
		return;
	}
	
     
    
    
    private function _update_contents($category_id, $contents)
    {
        foreach($contents as $iso => $data)
        {
            // update slug
			$data['slug'] = str_replace($iso . '/', '', $data['slug']);
			
            $slug		= $iso . '/';
			$slug		.= (empty($data['slug'])) ? url_title($data['title'], '-', TRUE) : url_title($data['slug'], '-', TRUE);
            $route_id   = $this->_get_route_id($category_id, $iso);
            
            $data['route_id']		= $this->route_model->update_slug($route_id, $slug);
            $data['active']         = (isset($data['active'])) ? $data['active'] : 0;
            
			unset($data['slug']);
			
            // update content for the iso
            $this->db->where(array('category_id' => $category_id, 'iso' => $iso))
                    ->update('category_contents', $data);
        }
    }
    
    private function _get_route_id($category_id, $iso)
    {
        return $this->db->get_where('category_contents', array('category_id' => $category_id, 'iso' => $iso))->row()->route_id;
    }
    
    
    
    private function _insert_contents($category_id, $contents)
    {
        $insert = array();
        {
            foreach($contents as $iso => $values)
            {
                $data                   = $values;
                $data['iso']            = $iso;
                $data['category_id']    = $category_id;
                $data['active']         = (isset($values['active'])) ? $values['active'] : 0;
                
                // slug generation
				$values['slug'] = str_replace($iso . '/', '', $values['slug']);
				
                $slug	= $iso . '/';
				$slug	.= (empty($values['slug'])) ? url_title($values['name'], '-', TRUE) : url_title($values['slug'], '-', TRUE);
                $data['route_id']   = $this->route_model->set_route($slug, 'front/categories/show/' . $category_id);
                unset($data['slug']);
                
                $insert[] = $data;
            }
        }
        $this->db->insert_batch('category_contents', $insert);
    }

    
    private function _get_category_contents($category_id)
    {
        $contents = $this->db->get_where('category_contents', array('category_id' => $category_id))->result('category_content');
        
        $return = array();
        foreach($contents as $content)
        {
            $content->set_slug($this->route_model->get_slug_by_id($content->route_id));
            $return[$content->iso] = $content;
        }
        return $return;
    }
  
    
    
    public function sort($list)
    {
        // recursive data extraction
        $data  = $this->_extract($list, 0);

        foreach($data as $item_data)
        {
            $this->db->where('id', $item_data['id']);
            $this->db->update('categories', $item_data);
        }
    }
    
    /**
     * recursive data extract from nested sortable hierarchy data
     * 
     * @param array $items
     * @param int $parent_id
     * @return array
     */
    private function _extract($items, $parent_id)
    {
        $data = array();
        
        foreach($items as $ord => $item)
        {
            // dump array data
            $data[] = array(
                'id'        => $item['id'],
                'parent_id' => $parent_id,
                'ord'       => $ord
            );
            
            // recursive for childrends
            if(isset($item['children']))
            {
                $childrens  = $this->_extract($item['children'], $item['id']);
                $data       = array_merge($data, $childrens);
            }
        }
        return $data;
        
    }
    
	private function _get_category_images($category_id)
    {
        $records = $this->db->order_by('ord')
                ->where('category_id', $category_id)
                ->get('category_images')->result();
        
        $images = array();
        foreach($records as $record)
        {
            $images[] = $this->image_model->get_image($record->image_id);
        }
        return $images;
    }
	
}
?>
