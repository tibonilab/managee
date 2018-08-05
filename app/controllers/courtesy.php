<?php

/**
 * Description of courtesy
 *
 * @author Alberto
 */
class Courtesy extends Main_controller {
	
	public function __construct() {
		parent::__construct();
		
		$this->layout->set_theme('courtesy');
		$this->layout_view = 'layouts/default';
	}
	
	public function index()
	{
		$this->layout->view('courtesy');
	}
	
}

?>