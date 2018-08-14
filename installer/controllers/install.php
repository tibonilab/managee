<?php 

class Install extends CI_Controller {
	
	public $data = [];
	public $db_driver;
	public $db;
	
    protected $_develop = TRUE;
	
	const DB_CONFIG_FILE = APPCONFIGPATH . 'config/database.php';    
	
    function __construct() {
		parent::__construct();        
		
		// we want to use mysqli when available
		$this->db_driver = function_exists('mysqli_connect') ? 'mysqli' : 'mysql';
		
		// init db connection
		$this->db = $this->load->database($this->_grab_db_config(), TRUE);
		
		// default installation check
		if($this->_is_installed() && uri_string() !== 'install') {
			redirect('install', 'refresh');
		}
	}
	
	public function index() 
	{
		if ($this->_is_installed()) 
		{
			$this->_view('installed');
		} 
		else 
		{
			$this->_goto_step(1);
		}
	}
	
	public function step1() 
	{
		if($this->form_validation->run()) {            
			
			
			if ( ! $this->_check_connection($this->db_driver)) 
			{
				$this->data['error'] = 'Database connection error. Please check provided informations.';
			} 
			else 
			{
				if ( ! $this->_update_database_config_file()) 
				{
					$this->data['error'] = 'Error writing config file: please enable write permission for file <b>'. self::DB_CONFIG_FILE .'</b>.';
				} 
				else 
				{
					$this->_goto_step(2);
				}
			}            
		} 
	
		$this->_view('step1');
	}
	
	public function step2() 
	{ 
		if($this->form_validation->run()) 
		{
			$this->load->library('database_generator');

			if($this->database_generator->database_exists()) 
			{
				$this->_goto_step('access');
			} 
			else 
			{
				$this->database_generator->create_db();
		
				$this->db->insert_batch('configs', [
					[
						'key' => 'website_title',
						'value' => $this->input->post('website_title')
					],
					[
						'key' => 'default_title',
						'value' => $this->input->post('default_title')
					],
					[
						'key' => 'frontend_theme',
						'value' => $this->input->post('frontend_theme')
					],
				]);
		
				$this->_goto_step(3);
			}
			
		}
	
		$this->_view('step2');
	}
	
	public function step3() 
	{ 
		if($this->form_validation->run())
		{
			// TODO: create user
	
			$this->db->insert('configs', [
				'key' => 'is_installed',
				'value' => '1'
			]);
	
			$this->_goto_step('access');
		}
	
		$this->_view('step3');
	}	
	
	private function _is_installed() {
		
		if ( $this->db->conn_id !== FALSE) 
		{
			
			if ($this->db->table_exists('configs')) 
			{
				$is_installed = $this->db->where('key', 'is_installed')
				->get('configs')
				->row();
				
				return $is_installed && (bool) $is_installed->value;	
			}
			
			return FALSE;
			
		}
		
		return FALSE;
	}
	
	private function _check_connection() {
		$config = [
			'hostname' => $this->input->post('hostname'),
			'database' => $this->input->post('database'),
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'dbdriver' => $this->db_driver
		];
		
		return $this->_test_conn_id($config);
	}
	
	private function _test_conn_id($config) {
		// test connection
		$connection = $this->load->database($config, TRUE);
		
		// conn_id is FALSE when connection failes
		return $connection->conn_id !== FALSE; 
	}
	
	private function _grab_db_config() {
		include(self::DB_CONFIG_FILE);

		return [
			'hostname' => $db['default']['hostname'],
			'database' => $db['default']['database'],
			'username' => $db['default']['username'],
			'password' => $db['default']['password'],
			'dbdriver' => $this->db_driver
		];
	}
	
	private function _update_database_config_file() {
		$this->load->helper('file');
		
		// read and explode db config file
		$exploded_db_config_file = explode("\n", read_file(self::DB_CONFIG_FILE));

		// init replacing array
		$search_value = [
			(object) [
				'search' => "\$db['default']['hostname']",
				'value' => $this->input->post('hostname')
			],
			(object) [
				'search' => "\$db['default']['database']",
				'value' => $this->input->post('database')
			],
			(object) [
				'search' => "\$db['default']['username']",
				'value' => $this->input->post('username')
			],
			(object) [
				'search' => "\$db['default']['password']",
				'value' => $this->input->post('password')
			],
			(object) [
				'search' => "\$db['default']['dbdriver']",
				'value' => $this->db_driver
			],

		];

		// cycle all config file lines
		for($k = 0; $k < count($exploded_db_config_file); $k++) 
		{
			// search for and replace value
			foreach($search_value as $obj) 
			{
				// value injection
				if(strpos($exploded_db_config_file[$k], $obj->search) !== FALSE) 
				{
					$exploded_db_config_file[$k] = $obj->search . " = '" . $obj->value . "';";
				}
			}
		}
		
		// save new config file
		$wrote = write_file(self::DB_CONFIG_FILE, implode("\n", $exploded_db_config_file));
		
		// wrote is FALSE when write fails
		return $wrote !== FALSE;
	}
	
	private function _goto_step($step) {
		if($step === 'access') {
			redirect(base_url('admin/dashboard'), 'refresh');
		} 
		
		redirect('install/step' . $step);
	}
	
	private function _view($view) {
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		// set content for layout with returned view...
		$viewData = [
			'content_for_layout' => $this->load->view('install/views/' . $view, $this->data, TRUE),
			'is_installed' => $this->_is_installed()
		];

		// ...and put it into default layout
		$this->load->view('install/layouts/default', $viewData);
	}
	
}