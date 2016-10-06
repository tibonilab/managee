<?php

/**
 * Description of type
 *
 * @author alberto
 */
class Link_content {
	public $link = FALSE;
    public $iso;
    public $active = TRUE;
    public $default_label;
	public $default_href;
	public $label;
	public $href;
	
	public function is_active()
    {
        return (bool) $this->active;
    }
	
	public function get_label()
	{
		return (empty($this->label)) ? $this->default_label : $this->label;
	}
	
	public function get_href()
	{
		return (empty($this->href)) ? $this->default_href : $this->href;
	}
}

?>
