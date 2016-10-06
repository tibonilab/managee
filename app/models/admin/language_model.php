<?php
/**
 * Description of language_model
 *
 * @author Alberto
 */
class Language_model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_all()
    {
        return $this->db->order_by('default', 'desc')
                ->where('active', 1)
                ->get('languages')->result('language');
    }
	   
}

?>
