<?php

/**
 * Description of Page_model
 *
 * @author Alberto
 */
class Partner extends Route{
	public $id;
	public $label;
	public $name;
    public $surname;
    
	
    function __construct($label = NULL)
    {
		parent::__construct();
        
		$this->label = $label;
		
        // init empty contents
		if($this->environment == 'admin')
		{
		//	$this->_init_contents();
		}
    }
    
    private function _init_contents()
    {
		foreach($this->languages as $lang)
		{
			$content = new Partner_content();
			$content->iso = $lang->iso;

			$this->_contents[$lang->iso] = $content;
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
	
	private function _set_images()
	{
		if($this->environment == 'front')
		{
			$this->_images = $this->front_partner_model->get_images($this->id);
		}
		else
		{
			$this->_images = $this->partner_model->get_images($this->id);
		}
	}
	
	private function _set_showcase()
	{
		$this->_showcase = ($this->has_showcase()) ? $this->front_showcase_model->get($this->showcase_id) : NULL;
	}
	
	public function set_content()
	{
		$this->_content = $this->front_partner_model->get_content($this->id);
		$this->set_route();
	}
	
	public function get_content($field)
	{
		return $this->_content->$field;
	}
	
    public function is_published()
    {
        return (bool) $this->published;
    }
	
    public function is_homepage()
    {
        return (bool) $this->is_homepage;
    }
    
	public function is_default_image($image_id)
    {
        return ($this->default_image_id == $image_id);
    }
	
    public function set_contents($contents)
    {
        $this->_contents = $contents;
    }
    
    public function get_contents()
    {
        return $this->_contents;
    }
	
	public function get_default_image()
    {
		if(is_null($this->_default_image))
		{
			$this->_set_default_image();
		}
        return $this->_default_image;
    }
	
	public function has_default_image()
	{
		if(is_null($this->_default_image))
		{
			$this->_set_default_image();
		}
        return (bool) $this->_default_image;
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
	
	public function has_form()
	{
		return (bool) $this->form;
	}
	
	public function get_form()
	{
		$template = '/partners/forms/' . $this->form;
		
		return file_exists(APPPATH . 'views' . '/themes/hotelveneziacattolica' . $template .'.php') ? $this->layout->load_view($template) : NULL;
	}
	
	
	
	public function get_showcase()
	{
		$this->_set_showcase();
				
		return $this->_showcase;
	}
	
	public function has_showcase()
	{
		return (bool) $this->showcase_id;
	}
	
}

?>
