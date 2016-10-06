<?php

class Attachment {
	
	public $id;
	public $filename;
	
	private $_attachment_folder;
	
	private $_contents	= NULL;
	private $_content	= NULL;
	
	function __construct() {
		$this->_set_attachment_folder();
		
		/*if($this->environment == 'admin')
		{
			//$this->_init_contents();
		}*/
	}
	
	/*private function _init_contents()
	{
		foreach($this->languages as $lang)
		{
			$content = new Attachment_content();
			$content->iso = $lang->iso;

			$this->_contents[$lang->iso] = $content;
		}
	}*/
	
	private function _set_attachment_folder()
	{
		/*if($this->params->item('attachment_folder'))
		{
			if(substr($this->params->item('attachment_folder'), -1) == '/')
				$this->_attachment_folder = $this->params->item('attachment_folder');
			else
				$this->_attachment_folder = $this->params->item('attachment_folder') . '/';
		}
		else
		{*/
			$this->_attachment_folder = './public/';
		//}
		
		//var_dump($this->_attachment_folder);
	}
	
	function __get($name) {
		return get_instance()->$name;
	}

	public function get_resource()
	{
		return './' . $this->_attachment_folder . $this->filename;
	}
	
	public function get_url()
	{
		return base_url($this->_attachment_folder . $this->filename);
	}
	
	public function get_contents($iso = NULL)
	{
		$this->_set_contents();
		
		if($iso)
		{
			return isset($this->_contents[$iso]) ? $this->_contents[$iso] : NULL;
		}
		
		return $this->_contents;
	}
		
	public function get_content($field = NULL)
	{
		$this->_set_content();
		
		if($field)
		{
			if($field == 'text' AND empty($this->_content->$field))
			{
				return $this->filename;
			}
			return (isset($this->_content->$field)) ? $this->_content->$field : NULL;
		}
		
		return $this->_content;
	}
	
	private function _set_content()
	{
		if(is_null($this->_content))
		{
			$this->db->where('iso', $this->iso);
			$this->db->where('attachment_id', $this->id);
			$this->_content = $this->db->get('attachment_contents')->row(0, 'attachment_content');
		}
	}
	
	private function _set_contents()
	{
		if(is_null($this->_contents))
		{
			$this->db->where('attachment_id', $this->id);
			$list = $this->db->get('attachment_contents')->result('attachment_content');
			
			$this->_contents = array();
			foreach($list as $item)
			{
				$this->_contents[$item->iso] = $item;
			}
		}
		
		
	}
}


?>