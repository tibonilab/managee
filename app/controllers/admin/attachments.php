<?php
/**
 * Description of products
 *
 * @author Alberto
 */
class Attachments extends Admin_controller {
    
    function __construct() {
        parent::__construct();
		
		$this->load->model('attachment_model');
    }
    
    public function index()
    {
        $this->layout->view('admin/attachments');
    }
    
	
	public function delete($id)
	{
        $attachment = $this->attachment_model->get($id);
		
		if($this->input->is_ajax_request())
		{
			if($attachment) $this->attachment_model->delete($attachment);
		}
		else
		{
			if( ! $attachment->id)
			{
				$this->set_message('warning', 'Impossibile trovare l\'allegato selezionato.');
				redirect($this->list);
			}
			else
			{
				$this->attachment_model->delete($attachment);
				$this->set_message('success', 'Allegato eliminato con sucesso!');
				redirect($this->list);
			}
		}
	}
	
	public function iframe_upload($type)
	{
		$this->layout_view = 'layouts/iframe';
        
        $this->data['uploaded'] = '';
                
        $files = array();
        $fdata = isset($_FILES['attachments']) ? $_FILES['attachments'] : false;
        if (is_array($fdata['name']))
        {
            for ($i=0; $i < count($fdata['name']); ++$i)
            {
                $files[] = array(
                 'name'			=> $fdata['name'][$i],
                 'tmp_name'     => $fdata['tmp_name'][$i],
                 'type' 		=> $fdata['type'][$i],
                 'size' 		=> $fdata['size'][$i],
                 'error' 		=> $fdata['error'][$i]
                );
            }
        }
        
        $stored_files = array();

        // se ci sono immagini nuove da caricare le processo
        if(count($files) > 0 && !empty($files[0]['name'])) 
        {
            $data['warning'] = '';

            // controlli e upload
            foreach($files as $file){
                if (TRUE)//($file["type"] == "attachment/jpeg" || $file["type"] == "attachment/png" || $file["type"] == "attachment/gif")	&& ($file["size"] < 10000000))
                {
                    if ($file["error"] > 0)
                    {
                        $data['warning'] .= "Errore durante il caricamento del file: '" . $file["name"] . "'<br />";
                    }
                    else
                    {
                        // filename override prevent
                        $new_filename   = $file["name"];
						$my_arr			= explode('.', $new_filename);
                        $file_ext       = end($my_arr);
                        $filename       = str_replace('.'.$file_ext, '', $new_filename);

                        $modifyer = 0;					
                        while(file_exists($this->config->item('default_attachments_path') . $new_filename))
                        {
                            $modifyer++;
                            $new_filename = $filename . '_' . $modifyer . '.' . $file_ext;
                        }

                        // uploading
                        move_uploaded_file($file["tmp_name"], './public/' . $new_filename);
                        $stored_files[] = $new_filename;
                    }
                }
                else
                {
                    $data['warning'] .= "Il file '". $file['name'] ."' è troppo grande o non è di un formato valido.<br />";
                }
            }

            $contents = array();
            foreach($this->languages as $lang)
            {
                $content = new Attachment_content();
                $content->iso = $lang->iso;

                $contents[$lang->iso] = (array)$content;
            }
            
            // resize, saving and showing
            foreach($stored_files as $file_name)
            {
                $save = array(
                        'filename' => $file_name,
                    );
                
                $id = $this->attachment_model->save(FALSE, $save, $contents);
                
                // attachments data for the view
                $this->data['uploaded'] .= $this->ajax_attachment($id, $type);
            }
        }
		
        $this->layout->view($type.'/snippets/iframe_upload_attachment');
	}
}

?>
