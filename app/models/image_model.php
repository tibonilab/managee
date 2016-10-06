<?php
/**
 * Description of image_model
 *
 * @author Alberto
 */
class Image_model extends MY_Model{
    
    function __construct() {
        parent::__construct();
    }

    public function init_content_rules()
    {
        $rules = array();
        
        foreach($this->languages as $lang)
        {
            $content_rules = array(
                    array(
                        'field' => 'content['.$lang->iso.'][title]',
                        'label' => '',
                        'rules' => ''
                    ),
                    array(
                        'field' => 'content['.$lang->iso.'][description]',
                        'label' => '',
                        'rules' => ''
                    ),
            );
            
            $rules = array_merge($rules, $content_rules);
        }
        
        return $rules;
    }
    
    
    public function init_validation_rules($id)
    {
        $rules = array(
            array(
                'field' => 'image[name]',
                'label' => 'Nome immagine',
                'rules' => ($id) ? 'trim|required|is_unique[pages.name.id.'.$id.']' : 'trim|required|is_unique[pages.name]'
            )
        );
        
        $rules = array_merge($rules, $this->init_content_rules());
        
        return $rules;
    }
    
    public function get_all()
    {
        return $this->db->get('images')->result('image');
    }
    
    
    public function get_image($id)
    {
		if ( ! $id) return new Image(FALSE);
		
		$image = $this->db->get_where('images', array('id' => $id))->row(0, 'image');
		
        return $image ? $image : new Image(FALSE);
    }
    
    
    public function save_batch($stored_files)
    {
        foreach($stored_files as $data)
        {
            $this->db->insert('images', $data['data']);
            $id = $this->db->insert_id();
            
            $this->_insert_contents($id, $data['contents']);
        }
    }
    
    
    public function save($id, $image, $contents)
    {
        if( ! $id)
        {
            $this->db->insert('images', $image);
            $id = $this->db->insert_id();
            
            $this->_insert_contents($id, $contents);
        }
        else
        {
            $this->db->where('id', $id)
                    ->update('images', $image);
            
            $this->_update_contents($id, $contents);
        }
        return $id;
    }
    
    
    public function delete($image)
    {
        $images_path    = substr($this->config->item('images_images_path'), 2);
        $upload_path    = substr($this->config->item('images_upload_path'), 2);
        $images_sizes   = $this->config->item('images_image_formats');

        // delete all resized images
        foreach($images_sizes as $resize_data)
        {
            $resource = $images_path . $resize_data['size'] . '/' . $image->src;
            if(file_exists($resource)) unlink($resource);
        }
        
        // delete uploaded file
        $resource = $upload_path . $image->src;
        if(file_exists($resource)) unlink($resource);
        
        $this->db->delete('images', array('id' => $image->id));
    }
    
    
    public function update_contents($image_id, $contents)
    {
        $this->_update_contents($image_id, $contents);
    }
    
    private function _update_contents($image_id, $contents)
    {
        foreach($contents as $iso => $data)
        {
            $this->db->where(array('image_id' => $image_id, 'iso' => $iso))
                    ->update('image_contents', $data);
        }
    }
    
    
    private function _insert_contents($image_id, $contents)
    {
        $insert = array();
        {
            foreach($contents as $iso => $values)
            {
                $data               = $values;
                $data['iso']        = $iso;
                $data['image_id']   = $image_id;
                
                $insert[] = $data;
            }
        }
        $this->db->insert_batch('image_contents', $insert);
    }

    
    public function get_image_contents($image_id)
    {
        $contents = $this->db->get_where('image_contents', array('image_id' => $image_id))->result('image_content');
        
        $return = array();
        foreach($contents as $content)
        {
            $return[$content->iso] = $content;
        }
        return $return;
    }    
    
	
	public function get_item_contents($image_id)
    {
        $contents = $this->db->get_where('image_contents', array('image_id' => $image_id))->result('image_content');
        
        $return = array();
        foreach($contents as $content)
        {
            $return[$content->iso] = $content;
        }
        return $return;
    }
}

?>
