<?php
/**
 * Description of products
 *
 * @author Alberto
 */
class Attachments extends Admin_controller {
    
    function __construct() {
        parent::__construct();
    }
    
    public function index()
    {
        $this->layout->view('attachments');
    }
    
}

?>
