<?php

/**
 * Description of text
 *
 * @author alberto
 */
class Text {
	
	public $id;
	public $key;
	public $type;
	public $memo;
	
	protected $_contents = array();
	
	function __construct() {
		if($this->environment == 'admin')
		{
			$this->_init_contents();
		}
	}
	
	private function _init_contents()
	{
        foreach($this->languages as $lang)
        {
            $content = new Text_content();
            $content->iso = $lang->iso;

            $this->_contents[$lang->iso] = $content;
        }
	}
		
	public function __get($var)
	{
		return get_instance()->$var;
	}
	
	public function set_contents()
	{
		$this->_contents = $this->text_model->get_contents($this->id);
	}
	
	public function get_contents()
	{
		return $this->_contents;
	}
	
	
	
	public function set_content()
	{
		$this->_content = $this->front_text_model->get_content($this->id);
	}
	
	public function get_content($field)
	{
		return (isset($this->_content->$field)) ? $this->_content->$field : NULL;
	}
	
}

?>
