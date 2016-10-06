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
		$slots = 100 - $this->db->from('subscribers')->count_all_results();
		
		$this->data['open_slots'] = ($slots < 0) ? 0 : $slots;
		
		$this->layout->view('courtesy');
	}
	
}

?>