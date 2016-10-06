<?php

/**
 * Description of type
 *
 * @author alberto
 */
class Property_content {
	public $property_id = FALSE;
    public $iso;
    public $active  = TRUE;
    public $label;
	public $icon;
	
	public function is_active()
    {
        return (bool) $this->active;
    }
}

?>
