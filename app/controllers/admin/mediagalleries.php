<?php
/**
 * Description of products
 *
 * @author Alberto
 */
class Mediagalleries extends Admin_controller {
    
    function __construct() {
        parent::__construct();
    }
    
    public function index()
    {
        $this->layout->view('mediagalleries');
    }
    
}

?>
