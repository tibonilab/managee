<?php

/**
 * Description of blog
 *
 * @author Alberto
 */
class Blog extends Front_controller {
	
	public function __construct() {
		parent::__construct();
	}
	
	public function index()
	{
		
		$this->layout->view('blog/index');
		
	}
	
}

?>
