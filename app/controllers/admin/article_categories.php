<?php
/**
 * Description of products
 *
 * @author Alberto
 */
class Article_categories extends Admin_controller {
    
    function __construct() {
        parent::__construct();
    }
    
    public function index()
    {
        $this->layout->view('article_categories');
    }
    
}

?>
