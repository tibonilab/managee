<?php

/**
 * Description of text_content
 *
 * @author alberto
 */
class Text_content {
    public $text_id = FALSE;
    public $iso;
    public $active  = TRUE;
    
    public $value;
    
	/**
	 * product language activation test
	 * 
	 * @access public
	 * @return bool
	 */
    public function is_active()
    {
        return (bool) $this->active;
    }
}

?>
