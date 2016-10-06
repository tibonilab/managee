<?php

/**
 * Description of text_model
 *
 * @author alberto
 */
class Text_model extends CI_Model{
	function __construct() {
		parent::__construct();
	}
	
	public function get_all()
	{
		if($this->input->get('key'))
		{
			$this->db->where('`memo` LIKE "%'.$this->input->get('key').'%" OR `key` LIKE "%'.$this->input->get('key').'%"');
		}
		
		$list = $this->db->order_by('memo')->get('texts')->result('text');
		
		foreach($list as $item)
		{
			$item->set_contents();
		}
		
		return $list;
	}
	
	public function get($id)
	{
		if( ! $id)	return new Text();
			
		$text = $this->db->get_where('texts', array('id' => $id))->row(0, 'text');
		
		if($text) $text->set_contents();
		
		return $text;
	}
	
	
	public function get_contents($text_id)
	{
		$contents = $this->db->get_where('text_contents', array('text_id' => $text_id))->result('text_content');
		
		$return = array();
		foreach($contents as $content)
		{
			$return[$content->iso] = $content; 
		}
		
		return $return;
	}
	
	public function delete($id)
	{
		$this->db->delete('texts', array('id' => $id));
	}
	
	public function save($id, $text_data, $content_data)
    {
        if( ! $id)
        {
            $this->db->insert('texts', $text_data);
            $id = $this->db->insert_id();
        }
        else
        {
            $this->db->where('id', $id)
                    ->update('texts', $text_data);
        }

		$this->_save_contents($id, $content_data);
		
        return $id;
    }
	
	private function _save_contents($text_id, $contents)
	{
		$this->db->delete('text_contents', array('text_id' => $text_id));
		
		$insert = array();
		foreach($contents as  $iso => $content)
		{
			$data = $content;
			$data['text_id']	= $text_id;
			$data['iso']		= $iso;
			$data['value']		= $content['value'];
			$data['active']		= (isset($content['active'])) ? 1 : 0;
			
			$insert[]	= $data;
			
		}
		$this->db->insert_batch('text_contents', $insert);
	}
	
	
	public function init_validation_rules($id)
	{
      $rules = array(
            array(
                'field' => 'text[key]',
                'label' => 'Codice',
                'rules' => ($id) ? 'trim|required|is_unique[texts.key.id.'.$id.']' : 'trim|required|is_unique[texts.key]'
            ),
            array(
                'field' => 'text[memo]',
                'label' => '',
                'rules' => ''
            ),
            array(
                'field' => 'text[type]',
                'label' => '',
                'rules' => ''
            )
        );
        
        foreach($this->languages as $lang)
        {
            $content_rules = array(
                    array(
                        'field' => 'content['.$lang->iso.'][value]',
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
	
}

?>
