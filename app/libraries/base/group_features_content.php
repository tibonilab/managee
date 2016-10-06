<?php
/**
 * Description of Group_features
 *
 * @author alberto
 */
class Group_features_content {
    public $group_id = FALSE;
    public $iso;
    public $label;
    public $active  = TRUE;
    
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
