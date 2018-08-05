<?php
/**
 * Description of Texts
 *
 * @author Alberto
 */
class Texts {
	
	private $_texts;
	
	public function __construct() {
		if(isset(get_instance()->db)) {
			$this->_init_texts();
		}
	}
	
	public function __get($var)
	{
		return get_instance()->$var;
	}
	
	private function _init_texts()
	{
		$this->load->model('front/front_text_model');
		$this->_texts = $this->front_text_model->get_all();
	}
	
	public function get($key)
	{
		return (isset($this->_texts[$key])) ? $this->_texts[$key] : NULL;
	}
	
	public function item($key)
	{
		return $this->get($key);
	}
	
}
