<?php
/**
 * Description of showcase
 *
 * @author Alberto
 */
class Showcase extends Route {
	
	public $id;
	public $name;
	public $featured	= TRUE;
	public $default;
	public $gallery;
	public $defulat_image_id;
	
	private $_images;
	private $_contents;
	private $_default_image;
	
	function __construct()
    {
		parent::__construct();
        
        // init empty contents
		if($this->environment == 'admin')
		{
			$this->_init_contents();
		}
    }
    
    private function _init_contents()
    {
		foreach($this->languages as $lang)
		{
			$content = new Showcase_content();
			$content->iso = $lang->iso;

			$this->_contents[$lang->iso] = $content;
		}
    }
	
	function __get($var)
	{
		return get_instance()->$var;
	}
	
	public function count_all_images()
	{
		if(is_null($this->_images))
		{
			$this->_set_images();
		}
		
		return count($this->_images);
	}
	
	public function set_images($images)
	{
		$this->_images = $images;
	}
	
	private function _set_images()
	{
		if($this->environment == 'admin')
		{
			$this->_images = ($this->is_featured()) ? $this->showcase_model->get_featured_products($this->id) : $this->showcase_model->get_images($this->id);
		}
		else
		{
			$this->_images = ($this->is_featured()) ? $this->front_showcase_model->get_showcase_feateured_products($this->id) : $this->front_showcase_model->get_showcase_images($this->id);
		}
	}
	
	public function get_images($index = FALSE)
	{
		if(is_null($this->_images))
		{
			$this->_set_images();
		}
		
		if($index !== FALSE)
		{
			return isset($this->_images[$index]) ? $this->_images[$index] : ($this->is_featured()) ? new Image() : new Product();
		}
		
		return $this->_images;
	}
	
	/**
	 * Check if $image_id is the default image id
	 * 
	 * @access public
	 * @param int $image_id
	 * @return bool

    public function is_default_image($image_id)
    {
        return ($this->default_image_id == $image_id);
    }	 */
	
	
	public function is_default()
	{
		return (bool) $this->default;
	}
	
	public function is_featured()
	{
		return (bool) $this->featured;
	}
	
		/**
	 * Check if $image_id is the default image id
	 * 
	 * @access public
	 * @param int $image_id
	 * @return bool
	 */
    public function is_default_image($image_id)
    {
        return ($this->default_image_id == $image_id);
    }
	
	private function _set_contents()
	{
		//if (is_null($this->_contents))
		//{
			$this->_contents = $this->showcase_model->get_showcase_contents($this->id);
		//}
	}
	
	
	public function get_contents($iso = NULL)
    {
		$this->_set_contents();
		
		if($iso)
		{
			return isset($this->_contents[$iso]) ? $this->_contents[$iso] : new Showcase_content();
		}
		
        return $this->_contents;
    }
	
	
	private function _set_content()
	{
		if (is_null($this->_contents))
		{
			$this->_contents = $this->front_showcase_model->get_content($this->id);
		}
	}
	
	private function _set_default_image()
    {
		if($this->default_image_id)
		{
			if($this->environment == 'admin')
			{
				$this->_default_image = $this->image_model->get_image($this->default_image_id);
			}
			else
			{
				$this->_default_image = $this->front_image_model->get($this->default_image_id);
			}
		}
		else
		{
			$this->_default_image = NULL;
		}
    }
	
	public function get_content($field)
	{
		$this->_set_content();
		
		return isset($this->_contents->$field) ? $this->_contents->$field : NULL;
	}
	
	
	public function get_default_image()
    {
		if(is_null($this->_default_image))
		{
			$this->_set_default_image();
		}
        return $this->_default_image;
    }
	
	public function has_deafult_image()
	{
		if(is_null($this->_default_image))
		{
			$this->_set_default_image();
		}
        return (bool) $this->_default_image;
	}
}

?>
