<?php 

class Install extends Front_Controller {

    public $environment = 'install';

    protected $_views_path = 'views';
    
    protected $_develop = TRUE;

    const DB_CONFIG_FILE = APPPATH . '/config/database.php';

    function __construct() {
        parent::__construct();
        
        $this->load->dbutil();
        $this->layout->set_theme('install');
        
        if($this->_is_installed() && uri_string() !== 'install') {
            redirect('install');
        }
    }
    
    private function _goto_step($step) {
        redirect('install/step' . $step);
    }
    
    public function index() {
        if ($this->_is_installed()) {
            $this->_view('installed');
        } else {
            $this->_goto_step(1);
        }
    }

    public function step1() {

        $this->form_validation->set_rules([
            [
                'field' => 'submit',
                'rules' => '',
                'label' => ''
            ],
        ]);

        if($this->form_validation->run()) {            
            // we want to use mysqli when available
            $db_driver = function_exists('mysqli_connect') ? 'mysqli' : 'mysql';

            $dummyConfig = [
                'hostname' => $this->input->post('hostname'),
                'database' => $this->input->post('database'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'dbdriver' => $db_driver
            ];

            // test connection
            $connection = $this->load->database($dummyConfig, true);

            if ( ! $connection->conn_id) {
                $this->data['error'] = 'Errore durante la connessione dal database: controlla i dati inseriti.';
            } else {
                $this->load->helper('file');
    
                // read and explode db config file
                $exploded_db_config_file = explode("\n", read_file(self::DB_CONFIG_FILE));
    
                // update configuration file
                $exploded_db_config_file[52] = "\$db['default']['hostname'] = '" . $this->input->post('hostname') . "';";
                $exploded_db_config_file[53] = "\$db['default']['database'] = '" . $this->input->post('database') . "';";
                $exploded_db_config_file[54] = "\$db['default']['username'] = '" . $this->input->post('username') . "';";
                $exploded_db_config_file[55] = "\$db['default']['password'] = '" . $this->input->post('password') . "';";
                $exploded_db_config_file[56] = "\$db['default']['dbdriver'] = '" . $db_driver . "';";

                // save new config file
                $wrote = write_file(self::DB_CONFIG_FILE, implode("\n", $exploded_db_config_file));
    
                if ( ! $wrote) {
                    $this->data['error'] = 'Errore di scrittura: abilita i permessi di scrittura per il file <b>app/config/database.php</b>.';
                } else {
                    $this->_goto_step(2);
                }
            }            
        } 

        $this->_view('step1');
    }

    public function step2() { 

        $this->form_validation->set_rules([
            [
                'field' => 'submit',
                'rules' => '',
                'label' => ''
            ],
        ]);

        if($this->form_validation->run()) {
            $this->_goto_step(3);
        }

        $this->_view('step2');
    }

    public function step3() { 
        $this->_view('step3');
    }
}