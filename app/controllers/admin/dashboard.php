<?php
/**
 * Description of admin
 *
 * @author Alberto
 */
class Dashboard extends Admin_controller {
    
    function __construct() {
        parent::__construct();
    }
    
    public function index()
    {
        $this->layout->view('dashboard');
    }
    
    public function products()
    {
        $this->load->model(array('product_model', 'category_model'));
        
        $products = $this->product_model->get_all();
        
        $this->data['products'] = $products;
        
        $this->layout->view('products/dashboard');
    }
    
    
    public function contents()
    {
        $this->layout->view('dashboard');
    }
    
    
    public function media()
    {
        $this->layout->view('dashboard');
    }
    
}

?>
