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
	
    public function __construct() {
        parent::__construct();
		$this->params = new Params();
		
        //default data here
        $this->layout->set_title($this->params->get('website_title'));
    }
    
    public function set_message($type, $message)
    {
        $this->session->set_flashdata($type, $message);
    }
    
    public function get_data()
    {
        return $this->data;
	}
	
	public function set_data(array $array = []) 
	{
		$this->data = array_merge($array, $this->data);
	}

	
}

?>