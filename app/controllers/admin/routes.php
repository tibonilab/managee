<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of routes
 *
 * @author Alberto
 */
class Routes extends Admin_controller {
	
	function __construct() {
		parent::__construct();
	}
	
	public function index()
	{
		$this->data['list'] = $this->route_model->get_all();
		
		$this->layout->view('routes/list');
	}
	
	public function form($id = NULL)
	{
		
	}
	
}

?>
