<?php
/**
 * Description of news_model
 *
 * @author Alberto
 */
class News_model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }

    public function init_validation_rules($id)
    {
        $rules = array(
            array(
                'field' => 'news[name]',
                'label' => 'Nome news',
                'rules' => ($id) ? 'trim|required|is_unique[news.name.id.'.$id.']' : 'trim|required|is_unique[news.name]'
            ),
            array(
                'field' => 'news[published]',
                'label' => '',
                'rules' => ''
            ),
			array(
                'field' => 'news[date]',
                'label' => '',
                'rules' => 'trim|required'
            )
        );
        
        foreach($this->languages as $lang)
        {
            $content_rules = array(
                    array(
                        'field' => 'content['.$lang->iso.'][title]',
                        'label' => '',
                        'rules' => ''
                    ),
                    array(
                        'field' => 'content['.$lang->iso.'][content]',
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
        
        return $rules;
    }
    
    public function get_all()
    {
		if($this->input->get('key'))
		{
			$this->db->where('name LIKE "%'.$this->input->get('key').'%"');
		}
		
        $news = $this->db->order_by('date', 'desc')->get('news')->result('news_lib');
        
        foreach($news as $item)
        {
            $item->set_contents($this->_get_news_contents($item->id));
        }
        
        return $news;
    }
    
    
    public function get_news($id)
    {
        $news = $this->db->get_where('news', array('id' => $id))->row(0, 'news_lib');
        
        if ( ! $news)
            return FALSE;
        
        $news->set_contents($this->_get_news_contents($news->id));
        
        return $news;
            
    }
    
    
    public function delete($news)
    {
        foreach($news->get_contents() as $content)
        {
			$this->db->where('id', $content->route_id);
            $this->db->update('routes', array('redirect' => base_url(), 'response_code' => 301));
        }
        
        $this->db->delete('news', array('id' => $news->id));
    }
    
    
    
    public function save($id, $news_data, $content_data, $image_data = NULL)
    {
		$news_data['published'] = (isset($news_data['published'])) ? 1 : 0;
		
        if( ! $id)
        {
            $this->db->insert('news', $news_data);
            $id = $this->db->insert_id();
            
            $this->_insert_contents($id, $content_data);
        }
        else
        {
            $this->db->where('id', $id)
                    ->update('news', $news_data);
            
            $this->_update_contents($id, $content_data);
        }
		
		$this->_save_images($id, $image_data);
        
        return $id;
    }
    
    private function _save_images($news_id, $images)
    {
        // reset image associations
        $this->db->delete('news_images', array('news_id' => $news_id));
        
		if (is_array($images))
		{
			// images associations
			$insert_batch = array();
			{
				foreach($images['id'] as $ord => $image_id)
				{
				   $insert_batch[] = array (
					   'news_id' => $news_id,
					   'image_id'   => $image_id,
					   'ord'        => $ord,
					   //'type'		=> $images[$image_id]['type']
				   );
				}
			}
			$this->db->insert_batch('news_images', $insert_batch);

			// save image contents
			$this->load->model('image_model');
			foreach($images['content'] as $image_id => $contents)
			{
				$this->image_model->update_contents($image_id, $contents);
			}
		}
        
    }     
    
    
    private function _update_contents($news_id, $contents)
    {
        foreach($contents as $iso => $data)
        {
			$data['slug'] = str_replace($iso . '/', '', $data['slug']);
			
            // update slug
            $slug		= $iso . '/';
			$slug		.= (empty($data['slug'])) ? url_title($data['title'], '-', TRUE) : url_title($data['slug'], '-', TRUE);
            $route_id   = $this->_get_route_id($news_id, $iso);
            
            $data['route_id']	= $this->route_model->update_slug($route_id, $slug);
            $data['active']     = (isset($data['active'])) ? $data['active'] : 0;
			
            unset($data['slug']);

            // update content for the iso
            $this->db->where(array('news_id' => $news_id, 'iso' => $iso))
                    ->update('news_contents', $data);
        }
    }
    
    private function _get_route_id($news_id, $iso)
    {
        return $this->db->get_where('news_contents', array('news_id' => $news_id, 'iso' => $iso))->row()->route_id;
    }
    
    
    
    private function _insert_contents($news_id, $contents)
    {
        $insert = array();
        {
            foreach($contents as $iso => $values)
            {
                $data               = $values;
                $data['iso']        = $iso;
                $data['news_id']    = $news_id;
                $data['active']     = (isset($values['active'])) ? $values['active'] : 0;
                
                // slug generation
                $values['slug'] = str_replace($iso . '/', '', $values['slug']);
				
				$slug	= $iso . '/';
				$slug	.= (empty($values['slug'])) ? url_title($values['title'], '-', TRUE) : url_title($values['slug'], '-', TRUE);
                $data['route_id']   = $this->route_model->set_route($slug, 'front/news/show/' . $news_id);
                unset($data['slug']);
                
                $insert[] = $data;
            }
        }
        $this->db->insert_batch('news_contents', $insert);
    }

    
    private function _get_news_contents($news_id)
    {
        $contents = $this->db->get_where('news_contents', array('news_id' => $news_id))->result('news_lib_content');
        
		//var_dump($contents);
		
        $return = array();
        foreach($contents as $content)
        {
            $content->set_slug($this->route_model->get_slug_by_id($content->route_id));
            $return[$content->iso] = $content;
        }
        return $return;
    }
	
	public function get_images($news_id)
    {
        $records = $this->db->order_by('ord')
                ->where('news_id', $news_id)
                ->get('news_images')->result();
        
        $images = array();
        foreach($records as $record)
        {
			$image = $this->image_model->get_image($record->image_id);
			//$image->set_type($this->_get_image_type($image->id, $news_id));
			
            $images[] = $image;
        }
        return $images;
    }
	
	private function _get_image_type($image_id, $news_id)
	{
		return $this->db->get_where('news_images', array('image_id' => $image_id, 'news_id' => $news_id))->row()->type;
	}
}

?>
