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
	public $db_driver;
    public $test_db;

	function __construct() {
		
		// we want to use mysqli when available
        $this->db_driver = function_exists('mysqli_connect') ? 'mysqli' : 'mysql';
		
        // test db connection
		$this->test_db =& DB($this->_grab_db_config());

        parent::__construct();
        
        if( ! $this->_is_installed()) 
        {
            redirect(base_url('install'));
        } 
        else 
        {
            $this->params = new Params();
            
            //default data here
            $this->layout->set_title($this->params->get('website_title'));
        }
	}
	
    private function _is_installed() {
		
		if ( $this->test_db->conn_id !== FALSE) {
			
			if ($this->test_db->table_exists('configs')) {
				$is_installed = $this->test_db->where('key', 'is_installed')
				->get('configs')
				->row();
				
				return $is_installed && (bool) $is_installed->value;
				
			}
			
			return FALSE;
			
		}
		
		return FALSE;
    }
    
    private function _grab_db_config() {
		include(APPPATH . 'config/database.php');

		return [
			'hostname' => $db['default']['hostname'],
			'database' => $db['default']['database'],
			'username' => $db['default']['username'],
			'password' => $db['default']['password'],
			'dbdriver' => $this->db_driver
		];
	}
    
    public function set_message($type, $message)
    {
        $this->session->set_flashdata($type, $message);
    }
    
    public function get_data()
    {
        return $this->data;
    }  
}

?>