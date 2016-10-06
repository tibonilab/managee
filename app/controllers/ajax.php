<?php

/**
 * Description of ajax
 *
 * @author Alberto
 */
class Ajax extends Main_controller {
	//put your code here
	public function __construct() {
		parent::__construct();
		
		if( ! $this->input->is_ajax_request())
		{
			exit(); 
		}
	}

    
    public function places()
	{
		$list = [];
		
		foreach($this->db->get('products')->result('product') as $item)
		{
			$list[] = $item;
		}
		
		echo json_encode($list);
	}
    
    
	public function gallery()
	{
		$list = [];
		
		$this->load->model('front/front_showcase_model');
		
		foreach($this->front_showcase_model->get_default_showcase()->get_images() as $item)
		{
			$list[] = base_url($item->get_showcase());
		}
		
		echo json_encode($list, JSON_UNESCAPED_SLASHES);
	}
	
	public function email()
	{		
        $msg = '';
        $status = FALSE;
        
        $this->form_validation->set_rules('contacts[name]', 'Nome', 'trim|required');
        $this->form_validation->set_rules('contacts[phone]', 'Telefono', 'trim|required|numeric');
        $this->form_validation->set_rules('contacts[email]', 'E-mail', 'trim|required|valid_email');
		$this->form_validation->set_rules('contacts[msg]', 'Messaggio', 'trim|required');
		$this->form_validation->set_rules('contacts[privacy]', 'Privacy', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
            $msg = '<div class="error"><h4>ATTENZIONE !</h4>' . validation_errors() . '</div>';
		}
		else
		{
            $post       = $this->input->post('contacts');
            
			$email		= $post['email'];
			$message	= 'Nome: ' . $post['name'] . '<br>Telefono: ' . $post['phone'] . '<br><br>' . $post['msg'];
			
			$this->load->library('email');
			
			$this->email->from('postmaster@agririo.it', 'postmaster agririo.it');
			$this->email->reply_to($email, $email);
			$this->email->to('mattia.agririo@gmail.com');
            //$this->email->to('a.tiboni@gmail.com');
			$this->email->subject('Messaggio da AgriRio.it');
			$this->email->message(nl2br($message));
			
			$send = $this->email->send();
			
			$this->db->insert('email_tracker', array(
				'from'		=> $email,
				'message'	=> nl2br($message),
				'status'	=> ($send) ? 1 : 0
			));
			
			if($send)
			{
				$msg    = '<div class="success"><h4>MESSAGGIO INVIATO !</h4>Grazie per averci contattato, ti risponderemo quanto prima.</div>';
                $status = TRUE;
			}
			else
			{
				$msg = '<div class="error"><h4>OOPS !</h4>Si è verificato un errore, attendi qualche istante e riprova, grazie.</div>';
			}
		}
        
        echo 
            json_encode(array(
                'msg'       => $msg,
                'status'    => $status
            )
        );
		
	}
	
	public function subscribe()
	{
		$this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email');
		//$this->form_validation->set_rules('name', 'Name', 'trim');
		//$this->form_validation->set_rules('message', 'Message', 'trim');
		
		$return = array(
			'status'	=> FALSE,
			'selector'	=> 'error',
			'msg'		=> ''
		);
		
		if ($this->form_validation->run() == FALSE)
		{
			$return['msg'] = validation_errors();
		}
		else
		{
			
			if($this->db->get_where('subscribers', array('email' => $this->input->post('email')))->row())
			{
				// already signed in
				$return = array(
					'status'	=> FALSE,
					'selector'	=> 'warning',
					'msg'		=> '<p>You\'re already signed in!</p>'
				);
			}
			else
			{
				// sign in
				$this->db->insert('subscribers', array(
					'email'		=> $this->input->post('email'),
					//'name'		=> $this->input->post('name'),
					//'message'	=> $this->input->post('message')
				));

				$return = array(
					'status'	=> TRUE,
					'selector'	=> 'success',
					'msg'		=> '<p>Well Done!</p>'
				);
			}
					
		}
		
		echo json_encode($return);
		
	}
	
}
