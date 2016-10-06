<?php
/**
 * Description of products
 *
 * @author Alberto
 */
class Images extends Admin_controller {
    
	public $list = 'admin/multimedia/immagini';
	
    function __construct() {
        parent::__construct();
        $this->load->model('image_model');
        $this->load->config('files');
    }
    
    public function index()
    {
        $images = $this->image_model->get_all();
        
        $this->data['images'] = $images;
        
        $this->layout->view('images');
    }
    
    public function form($id = FALSE)
    {
        if($id)
        {
            $image      = $this->image_model->get_image($id);
            $contents   = $image->get_contents();
        }
        else 
        {
            $image = new Image();
            
            // set empty languages content
            $contents = array();
            foreach($this->languages as $lang)
            {
                $content = new Image_content();
                $content->iso = $lang->iso;
                
                $contents[$lang->iso] = $content;
            }
        }
        
        $this->data['image']    = $image;
        $this->data['contents'] = $contents;
        
        $this->form_validation->set_rules($this->image_model->init_validation_rules($id));
        
        if($this->form_validation->run() == FALSE)
        {
            $this->layout->view('image_form');
        }
        else
        {
            $file_name = FALSE;
                
            // upload image only if selected
            if(isset($_FILES['filename']))
            {
                $this->load->library('upload', $this->config->item('images_upload_library_config'));
                
                //upload error
                if ( ! $this->upload->do_upload('filename')) 
                {
                    $this->data['error'] = $this->upload->display_errors();
                    $this->layout->view('image_form');
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $file_name = $upload_data['file_name'];
                }
            }

            //image resize
            $this->load->helper('image_resizer');
            resize_image($file_name, 'images_');

            $image_data         = $this->input->post('image');
            if($file_name) $image_data['src']  = $file_name;

            $content_data       = $this->input->post('content');

            $image_id = $this->image_model->save($id, $image_data, $content_data);

            $this->set_message('success', 'Immagine inserita con successo!');
            redirect($this->list);
        }
    }
    
    
    public function delete($id)
    {
        $image = $this->image_model->get_image($id);
		
		if($this->input->is_ajax_request())
		{
			if($image) $this->image_model->delete($image);
		}
		else
		{
			if( ! $image->id)
			{
				$this->set_message('warning', 'Impossibile trovare l\'immagine selezionata.');
				redirect($this->list);
			}
			else
			{
				$this->image_model->delete($image);
				$this->set_message('success', 'Immagine eliminata con sucesso!');
				redirect($this->list);
			}
		}
    }
	
	
	
	public function iframe_upload($type = 'products')
    {
        $this->layout_view = 'layouts/iframe';
        
        $this->data['uploaded'] = '';
                
        $files = array();
        $fdata = isset($_FILES['images']) ? $_FILES['images'] : false;
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
                if (($file["type"] == "image/jpeg" || $file["type"] == "image/png" || $file["type"] == "image/gif")	&& ($file["size"] < 10000000))
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
                        while(file_exists($this->config->item('images_upload_path') . $new_filename))
                        {
                            $modifyer++;
                            $new_filename = $filename . '_' . $modifyer . '.' . $file_ext;
                        }

                        // uploading
                        move_uploaded_file($file["tmp_name"], $this->config->item('images_upload_path') . $new_filename);
                        $stored_files[] = $new_filename;
                    }
                }
                else
                {
                    $data['warning'] .= "Il file '". $file['name'] ."' è troppo grande o non è di un formato valido.<br />";
                }
            }
			
            // images resize
            $this->load->helper('image_resizer');
			
			
            
            // TODO - SPOSTARE QUESTO CICLO NELLA LIBRARY Image_conten sul __construct()
            $contents = array();
            foreach($this->languages as $lang)
            {
                $content = new Image_content();
                $content->iso = $lang->iso;

                $contents[$lang->iso] = (array)$content;
            }
            
            // resize, saving and showing
            foreach($stored_files as $file_name)
            {
                // image resize
                resize_image($file_name, 'images_');

                $save = array(
                        'src' => $file_name,
                        'name' => $file_name
                    );
                
                $id = $this->image_model->save(FALSE, $save, $contents);
                
                // images data for the view
                $this->data['uploaded'] .= $this->ajax_image($id, $type);
            }
        }
		
        $this->layout->view($type.'/snippets/iframe_upload');
    }
    
}

?>
