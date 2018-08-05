<?php
/**
 * Description of Main_controller
 *
 * @author Alberto
 */
class Main_controller extends CI_Controller {
    
	// data passed to the layout view
    protected $data	=  array();
	
	// used for backend/frontend environment
	public $environment;
	
	// database project parameters
	public $params;

    protected $_develop;

    public function __construct() {
        parent::__construct();

        if( $this->_is_installed()) {
			$this->load->database();
            $this->params = new Params();
            
            //default data here
            $this->layout->set_title($this->params->get('website_title'));
        }
    }
    
    public function set_message($type, $message)
    {
        $this->session->set_flashdata($type, $message);
    }
    
    public function get_data()
    {
        return $this->data;
    }

    protected function _is_installed() {
        if($this->_develop) return false; 

        $this->load->dbutil();

        return property_exists($this, 'db') && $this->db->database && $this->dbutil->database_exists($this->db->database);
    }


	
}

?>