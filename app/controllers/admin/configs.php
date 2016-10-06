<?php
/**
 * Description of products
 *
 * @author Alberto
 */
class Configs extends Admin_controller {
	
	public $list = 'admin/configs';
	
    function __construct() {
        parent::__construct();
    }
    
    public function index()
    {
		$this->data['list'] = $this->db->get('configs')->result();
        $this->layout->view('configs/list');
    }
	
	public function form($id = NULL)
	{
		$param = $this->db->get_where('configs', array('id' => $id))->row('config');
		$param = ($param) ? $param : new Config();
		
		$this->form_validation->set_rules('param[key]', 'Chiave', 'trim|required');
		$this->form_validation->set_rules('param[value]', 'Valore', 'trim|required');
		$this->form_validation->set_rules('param[memo]', '', '');
		
		if($this->form_validation->run() == FALSE)
		{
			$this->data['param'] = $param;
			$this->layout->view('configs/form');
		}
		else
		{
			if($id)
			{
				$this->db->where('id', $id);
				$this->db->update('configs', $this->input->post('param'));
			}
			else 
			{
				$this->db->insert('configs', $this->input->post('param'));
			}
			$this->set_message('success', 'Parametro salvato con successo!');
			redirect($this->list);
		}
		
	}
	
}

?>
