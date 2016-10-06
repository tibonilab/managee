<?php

class Attachment_model extends MY_Model{
	
	public function __construct() {
		parent::__construct();
	}
	
	public function get($id)
	{
		$this->db->where('id', $id);
		return $this->db->get('attachments')->row(0, 'attachment');
	}
	
	public function delete(Attachment $attachment)
	{
		if(file_exists($attachment->get_resource()))
		{
			unlink($attachment->get_resource());
		}
		return $this->db->delete('attachments', array('id' => $attachment->id));
	}
	
	public function save($id, $data, $contents)
    {
        if( ! $id)
        {
            $this->db->insert('attachments', $data);
            $id = $this->db->insert_id();
        }
        else
        {
            $this->db->where('id', $id)
                    ->update('attachments', $data);
        }
		
		$this->_update_contents($id, $contents);
		
        return $id;
    }
	
	
	public function update_contents($id, $contents)
	{
		foreach($contents as $iso => $data)
        {
            $this->db->where(array('attachment_id' => $id, 'iso' => $iso))
                    ->update('attachment_contents', $data);
        }
	}
	
	private function _update_contents($id, $contents)
	{
		$this->db->delete('attachment_contents', array('attachment_id' => $id));
		
		$insert_batch = array();
		foreach($contents as $iso => $data)
		{
			$data['iso']			= $iso;
			$data['attachment_id']	= $id;
			$insert_batch[]			= $data;
		}
		$this->db->insert_batch('attachment_contents', $insert_batch);
	}
}
