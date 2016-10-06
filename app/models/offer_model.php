<?php
/**
 * Description of offer_model
 *
 * @author Alberto
 */
class Offer_model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }

    public function init_validation_rules($id)
    {
        $rules = array(
            array(
                'field' => 'offer[name]',
                'label' => 'Nome offerta',
                'rules' => ($id) ? 'trim|required|is_unique[offers.name.id.'.$id.']' : 'trim|required|is_unique[offers.name]'
            ),
            array(
                'field' => 'offer[published]',
                'label' => '',
                'rules' => ''
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
                        'field' => 'content['.$lang->iso.'][subtitle]',
                        'label' => '',
                        'rules' => ''
                    ),
					array(
                        'field' => 'content['.$lang->iso.'][list]',
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
		
        $offer = $this->db->order_by('ord')->get('offers')->result('offer');
        
        foreach($offer as $item)
        {
            $item->set_contents($this->_get_offer_contents($item->id));
        }
        
        return $offer;
    }
    
    
    public function get_offer($id)
    {
        $offer = $this->db->get_where('offers', array('id' => $id))->row(0, 'offer');
        
        if ( ! $offer)
            return FALSE;
        
        $offer->set_contents($this->_get_offer_contents($offer->id));
        
        return $offer;
            
    }
    
    
    public function delete($offer)
    {
        foreach($offer->get_contents() as $content)
        {
			$this->db->where('id', $content->route_id);
            $this->db->update('routes', array('redirect' => base_url(), 'response_code' => 301));
        }
        
        $this->db->delete('offers', array('id' => $offer->id));
    }
    
    
    
    public function save($id, $offer_data, $content_data, $image_data = NULL)
    {
        $offer_data['published'] = (isset($offer_data['published'])) ? 1 : 0;
        $offer_data['in_homepage'] = (isset($offer_data['in_homepage'])) ? $offer_data['in_homepage'] : 0;
		
        if( ! $id)
        {
            $this->db->insert('offers', $offer_data);
            $id = $this->db->insert_id();
            
            $this->_insert_contents($id, $content_data);
        }
        else
        {
            $this->db->where('id', $id)
                    ->update('offers', $offer_data);
            
            $this->_update_contents($id, $content_data);
        }
		
		$this->_save_images($id, $image_data);
        
        return $id;
    }
    
    private function _save_images($offer_id, $images)
    {
        // reset image associations
        $this->db->delete('offer_images', array('offer_id' => $offer_id));
        
		if (is_array($images))
		{
			// images associations
			$insert_batch = array();
			{
				foreach($images['id'] as $ord => $image_id)
				{
				   $insert_batch[] = array (
					   'offer_id' => $offer_id,
					   'image_id'   => $image_id,
					   'ord'        => $ord,
					   //'type'		=> $images[$image_id]['type']
				   );
				}
			}
			$this->db->insert_batch('offer_images', $insert_batch);

			// save image contents
			$this->load->model('image_model');
			foreach($images['content'] as $image_id => $contents)
			{
				$this->image_model->update_contents($image_id, $contents);
			}
		}
        
    }
    
    private function _update_contents($offer_id, $contents)
    {
        foreach($contents as $iso => $data)
        {
            // update slug
			$data['slug'] = str_replace($iso . '/', '', $data['slug']);
			
            $slug		= $iso . '/';
			$slug		.= (empty($data['slug'])) ? url_title($data['title'], '-', TRUE) : url_title($data['slug'], '-', TRUE);
            $route_id   = $this->_get_route_id($offer_id, $iso);
            
            $data['route_id']	= $this->route_model->update_slug($route_id, $slug);
            $data['active']     = (isset($data['active'])) ? $data['active'] : 0;

			unset($data['slug']);
            
            // update content for the iso
            $this->db->where(array('offer_id' => $offer_id, 'iso' => $iso))
                    ->update('offer_contents', $data);
        }
    }
    
    private function _get_route_id($offer_id, $iso)
    {
        return $this->db->get_where('offer_contents', array('offer_id' => $offer_id, 'iso' => $iso))->row()->route_id;
    }
    
    
    
    private function _insert_contents($offer_id, $contents)
    {
        $insert = array();
        {
            foreach($contents as $iso => $values)
            {
                $data               = $values;
                $data['iso']        = $iso;
                $data['offer_id']    = $offer_id;
                $data['active']     = (isset($values['active'])) ? $values['active'] : 0;
                
                // slug generation
				$values['slug'] = str_replace($iso . '/', '', $values['slug']);
				
                $slug	= $iso . '/';
				$slug	.= (empty($values['slug'])) ? url_title($values['title'], '-', TRUE) : url_title($values['slug'], '-', TRUE);
                $data['route_id']   = $this->route_model->set_route($slug, 'front/offers/show/' . $offer_id);
                unset($data['slug']);
                
                $insert[] = $data;
            }
        }
        $this->db->insert_batch('offer_contents', $insert);
    }

    
    private function _get_offer_contents($offer_id)
    {
        $contents = $this->db->get_where('offer_contents', array('offer_id' => $offer_id))->result('offer_content');
        
        $return = array();
        foreach($contents as $content)
        {
            $content->set_slug($this->route_model->get_slug_by_id($content->route_id));
            $return[$content->iso] = $content;
        }
        return $return;
    }
	
	public function get_images($offer_id)
    {
        $records = $this->db->order_by('ord')
                ->where('offer_id', $offer_id)
                ->get('offer_images')->result();
        
        $images = array();
        foreach($records as $record)
        {
			$image = $this->image_model->get_image($record->image_id);
			//$image->set_type($this->_get_image_type($image->id, $offer_id));
			
            $images[] = $image;
        }
        return $images;
    }
	
	private function _get_image_type($image_id, $offer_id)
	{
		return $this->db->get_where('offer_images', array('image_id' => $image_id, 'offer_id' => $offer_id))->row()->type;
	}
	
	public function sort()
	{
		foreach($this->input->post('item') as $ord => $id)
		{
			$this->db->where('id', $id);
			$this->db->update('offers', array('ord' => $ord));
		}
	}
}

?>
