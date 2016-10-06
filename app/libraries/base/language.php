<?php

/**
 * Description of Language
 *
 * @author Alberto
 */
class Language {
    public $iso;
    public $description;
    public $default = FALSE;
    public $active	= FALSE;
	public $state;
	public $sign;
    
    public function is_active()
    {
        return (bool) $this->active;
    }
    
    public function is_default()
    {
        return (bool) $this->default;
    }
}

?>
