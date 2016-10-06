<?php
/**
 * Description of products
 *
 * @author Alberto
 */
class Customers extends Admin_controller {
    
    function __construct() {
        parent::__construct();
    }
    
    public function index()
    {
        $this->layout->view('customers');
    }
    
}

?>
