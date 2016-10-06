<?php

/**
 * Description of News_lib
 *
 * @author Alberto
 */
class News_lib extends Route {
    public $id;
    public $name;
	public $date;
    public $published = FALSE;
	public $default_image_id;
    
    private $_contents;
    private $_content;
	private $_images;
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
            $content = new Page_content();
            $content->iso = $lang->iso;

            $this->_contents[$lang->iso] = $content;
        }
    }

	private function _set_default_image()
    {
		if($this->has_deafult_image())
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
	
	private function _set_images()
	{
		if($this->environment == 'front')
		{
			$this->_images = $this->front_news_model->get_images($this->id);
		}
		else
		{
			$this->_images = $this->news_model->get_images($this->id);
		}
	}
	
	
    public function set_content()
	{
		$this->_content = $this->front_news_model->get_content($this->id);
		$this->set_route();
	}

	
	public function get_content($field, $trim = FALSE)
	{
		return ($trim) ? substr(strip_tags($this->_content->$field), 0, $trim) . '...' : $this->_content->$field;
	}
    
    public function is_published()
    {
        return (bool) $this->published;
    }
    
    public function set_contents($contents)
    {
        $this->_contents = $contents;
    }
    
    public function get_contents()
    {
        return $this->_contents;
    }
	
	public function get_date()
	{
		return ymd_to_dmy($this->date);
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
        return (bool) $this->default_image_id;
	}
	
	public function get_images($type = NULL)
    {
		if(is_null($this->_images))
		{
			$this->_set_images();
		}
		
		if($type) // frontend
		{
			return (isset($this->_images[$type])) ? $this->_images[$type] : array();
		}
		
		// backend 
		return $this->_images;
    }
	
	    
	public function is_default_image($image_id)
    {
        return ($this->default_image_id == $image_id);
    }
}

?>
