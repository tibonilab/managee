<?php 

class Install extends CI_Controller {

	public $data = [];
	public $db_driver;
	public $db;
	
    protected $_develop = TRUE;

    const DB_CONFIG_FILE = APPCONFIGPATH . 'config/database.php';
    const INSTALLER_DB_CONFIG_FILE = APPPATH . 'config/database.php';

    function __construct() {
        parent::__construct();        
		
		// we want to use mysqli when available
		$this->db_driver = function_exists('mysqli_connect') ? 'mysqli' : 'mysql';

		// init db connection
		$this->db = $this->load->database($this->_grab_db_config(), TRUE);

		if($this->_is_installed() && uri_string() !== 'install') {
            redirect('install');
		}
    }
	
	private function _view($view) {
		$this->form_validation->set_error_delimiters('<span class="error">', '</span>');

		// set content for layout with returned view...
		$viewData = [
			'content_for_layout' => $this->load->view('install/views/' . $view, $this->data, TRUE)
		];

		// ...and put it into default layout
		$this->load->view('install/layouts/default', $viewData);
	}

	private function _grab_db_config() {
		require_once(APPPATH . 'config/database.php');

		return [
			'hostname' => $db['default']['hostname'],
			'database' => $db['default']['database'],
			'username' => $db['default']['username'],
			'password' => $db['default']['password'],
			'dbdriver' => $this->db_driver
		];
	}

	private function _is_installed() {

		if ( $this->db->conn_id !== FALSE) {
			$is_installed = $this->db->where('key', 'is_installed')
				->get('configs')
				->row();

			return $is_installed && (bool) $is_installed->value;
		}

		return FALSE;
	}

    private function _goto_step($step) {
        redirect('install/step' . $step);
    }
	
	private function _test_conn_id($config) {
		// test connection
		$connection = $this->load->database($config, TRUE);

		// conn_id is FALSE when connection failes
		return $connection->conn_id !== FALSE; 
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

	private function _update_database_config_file($path_to_config_file) {
		$this->load->helper('file');
    
		// read and explode db config file
		$exploded_db_config_file = explode("\n", read_file($path_to_config_file));

		// update configuration file
		$exploded_db_config_file[52] = "\$db['default']['hostname'] = '" . $this->input->post('hostname') . "';";
		$exploded_db_config_file[53] = "\$db['default']['database'] = '" . $this->input->post('database') . "';";
		$exploded_db_config_file[54] = "\$db['default']['username'] = '" . $this->input->post('username') . "';";
		$exploded_db_config_file[55] = "\$db['default']['password'] = '" . $this->input->post('password') . "';";
		$exploded_db_config_file[56] = "\$db['default']['dbdriver'] = '" . $this->db_driver . "';";

		// save new config file
		$wrote = write_file($path_to_config_file, implode("\n", $exploded_db_config_file));

		// wrote is FALSE when write fails
		return $wrote !== FALSE;
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
				if ( ! $this->_update_database_config_file(self::DB_CONFIG_FILE)) 
				{
                    $this->data['error'] = 'Error writing config file: please enable write permission for file <b>'.self::DB_CONFIG_FILE.'</b>.';
				} 
				else if ( ! $this->_update_database_config_file(self::INSTALLER_DB_CONFIG_FILE)) 
				{
                    $this->data['error'] = 'Error writing config file: please enable write permission for file <b>'.self::INSTALLER_DB_CONFIG_FILE.'</b>.';
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
			// TODO: create empty db

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

			redirect('admin');
		}

        $this->_view('step3');
    }
}