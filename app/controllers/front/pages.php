<?php
/**
 * Description of pages
 *
 * @author alberto
 */
class Pages extends Front_controller{
	
	protected $_views_path = 'pages';
	
	function __construct() {
		parent::__construct();
		$this->load->model(array(
			'front/front_page_model', 
			'front/front_news_model',
			'front/front_showcase_model'
		));
		
	}

	
	public function show($id)
	{
		$item = $this->front_page_model->get($id);
		
		if( ! $item ) 
		{
			redirect(home_url());
		}
		
		$this->set_meta_by($item);
		
		if($item->category_id) 
		{
			$this->data['breadcrumbs']['list'] = $this->front_category_model->get_breadcrumbs($this->front_category_model->get($item->category_id));
		}
		
		$this->data['item'] = $item;
		
        if($this->input->is_ajax_request())
        {
            echo $this->layout->snippet('pages/show', array('item' => $item));
        }
        else
        {
            $this->_view('show');
        }
	}
	
	
	public function contacts()
	{
        $rules = array(
            array(
                'field' => 'name',
                'label' => 'Nome / Name',
                'rules' => 'trim|required'
            ),
            array(
                'field' => 'email',
                'label' => 'E-mail',
                'rules' => 'trim|required|valid_email'
            ),
            array(
                'field' => 'position',
                'label' => 'Posizione / Position',
                'rules' => 'required'
            ),
            array(
                'field' => 'request',
                'label' => 'Richiesta / Request',
                'rules' => 'trim|required'
            ),
			array(
                'field' => 'privacy',
                'label' => 'Privacy',
                'rules' => 'required'
            )
        );

        $this->form_validation->set_rules($rules);
        $this->form_validation->set_error_delimiters('<p class="alert">', '</p>');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->layout->view('pages/contacts');
        }
        else
        {
            $this->load->library('email');
            
            $this->email->from($this->input->post('email'), $this->input->post('name'));
            //$this->email->to('info@tibonilab.com'); 
            $this->email->to('info@logicsun.it');
            
            $this->email->subject('Messaggio da montaltolamp.com');
            
            $message = 'Nome: <b>'. $this->input->post('name') .'</b><br>';
            $message .= 'E-mail: '. $this->input->post('email') .'<br>';
            $message .= 'Posizione: <b>'. $this->input->post('position') .'</b><br><br>';
            $message .= 'Richiesta: <br><br>'. $this->input->post('request');
            
            $this->email->message(nl2br($message));

            if ( ! $this->email->send())
            {
                $data['msg'] = '<p class="alert">Impossibile inviare / Unable to send</p>';
                $this->layout->view('pages/contacts', $data);
            }
            else
            {
                $this->set_message('msg', '<p class="success">Richiesta inviata / Request sent</p>');
                redirect(site_url(lang('menu-contacts_url')));
            }
        }
	}
	
	public function test()
	{
		$this->_view('test');
	}
}

?>
