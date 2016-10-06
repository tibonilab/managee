<?php
/**
 * Description of products
 *
 * @author Alberto
 */
class Articles extends Admin_controller {
    
    function __construct() {
        parent::__construct();
    }
    
    public function index()
    {
        $this->layout->view('articles');
    }
    
}

?>
