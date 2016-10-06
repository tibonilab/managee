<?php

/**
 * Description of MY_Model
 *
 * @author Alberto
 */
class MY_Model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
}

class Front_Model extends MY_Model {
	
	protected $iso;
	
	function __construct() {
		parent::__construct();
		
		$this->iso = $this->lang->lang();
	}
}

?>
