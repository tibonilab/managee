<?php
/**
 * Description of Group_features
 *
 * @author alberto
 */
class Group_features {
    public $id;
    public $name;
    
    protected $_contents;
    protected $_features;
    
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
    
	public function set_content()
	{
		$this->_content = $this->_CI->front_group_features_model->get_content($this->id);
	}
	
	public function get_content($field)
	{
		return $this->_content->$field;
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
            $content = new Group_features_content();
            $content->iso = $lang->iso;

            $this->_contents[$lang->iso] = $content;
        }
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
    
    public function set_features($features)
    {
        $this->_features = $features;
    }
    
    public function get_features()
    {
        return $this->_features;
    }
}

?>
