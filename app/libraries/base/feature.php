<?php
/**
 * Description of Category
 *
 * @author Alberto
 */
class Feature {

    public $name;
    public $parent_id;
    public $visible = FALSE;
	public $type;
    
    private $_contents; // translations
        
    private $_CI;
    
    function __construct()
    {
        $this->_CI =& get_instance();
        
		if($this->_CI->environment == 'admin')
		{
			// init empty contents
			$this->_init_contents();
		}
    }
    
	/**
	 * set empty product content translations list
	 * 
	 * @access private
	 */
    private function _init_contents()
    {
        foreach($this->_CI->languages as $lang)
        {
            $content = new Feature_content();
            $content->iso = $lang->iso;

            $this->_contents[$lang->iso] = $content;
        }
    }
    
	public function set_version_content($content)
	{
		$this->_content = $content;
	}
	
	public function set_content($entity, $entity_type)
	{
		$this->_content = $this->_CI->front_feature_model->get_content($this, $entity, $entity_type);
	}
	
	public function get_content($field)
	{
		return $this->_content->$field;
	}
	
	/*public function get_content_td()
	{
		return '<td>'. $this->_content->label.': </td><td class="text-right">'.$this->_content->value.' '.$this->_content->extra .'</td>';
	}*/
	
    public function is_visible()
    {
        return (bool) $this->visible;
    }
    
    public function set_contents($contents)
    {
        $this->_contents = $contents;
    }
    
    public function get_contents($iso = NULL, $field = FALSE)
    {
		if($iso AND $field)
		{
			return (isset($this->_contents[$iso]) AND isset($this->_contents[$iso]->$field)) ? $this->_contents[$iso]->$field : NULL;
		}
		
		if($iso AND ! $field)
		{
			return (isset($this->_contents[$iso])) ? $this->_contents[$iso] : new Feature_content;
		}
		
        return $this->_contents;
    }
}

?>
