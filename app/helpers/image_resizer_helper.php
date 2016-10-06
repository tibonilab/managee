<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('resize_image'))
{
    function resize_image($file_name, $config_prefix)
    {
		
		
        $CI =& get_instance();
        $CI->load->library('image_lib');
        
        // grab configuration data from config
        $image_formats      = $CI->config->item($config_prefix . 'image_formats');
        $uploaded_path      = $CI->config->item($config_prefix . 'upload_path');
        $images_path        = $CI->config->item($config_prefix . 'images_path');
        $uploaded_resource  = $uploaded_path . $file_name;
        
		
		
        // get uploaded image informations
        $uploaded_data = $CI->image_lib->get_image_properties($uploaded_resource, TRUE);
        
        // resize image in all formats
        foreach($image_formats as $resizing_data)
        {
            $new_fullpath = $images_path . $resizing_data['size'] . '/' . $file_name;
            
			if($resizing_data['size'] == 'showcase')
			{
				// uploaded image ratio
				$ratio = $uploaded_data['width'] / $uploaded_data['height'];
				
				// showcase size ratio
				$limit = $resizing_data['width'] / $resizing_data['height'];
				
				// master dimension by ratio
				$resize['master_dim'] = ($ratio > $limit) ? 'height' : 'width';
				
				$resize['image_library']    = 'gd2';
				$resize['quality']			= '100%';
				$resize['source_image']     = $uploaded_resource;
				$resize['new_image']        = $new_fullpath;
				$resize['maintain_ratio']   = TRUE;
				$resize['width']            = $resizing_data['width'];
				$resize['height']           = $resizing_data['height'];
				
				
				$CI->image_lib->initialize($resize);
				$CI->image_lib->resize();
				
				// get image data after resize
				$resized_data = $CI->image_lib->get_image_properties($new_fullpath, TRUE);
				
				$x_axis = ($resized_data['width'] - $resizing_data['width']) / 2;
				$y_axis = ($resized_data['height'] - $resizing_data['height']) / 2;
				
				$crop['image_library']  = 'gd2';
				$crop['source_image']   = $new_fullpath;
				$crop['quality']			= '100%';
				$crop['maintain_ratio']	= FALSE;
				$crop['width']          = $resizing_data['width'];
				$crop['height']         = $resizing_data['height'];
				$crop['x_axis']         = $x_axis;
				$crop['y_axis']         = $y_axis;

				$CI->image_lib->initialize($crop);
				$CI->image_lib->crop();
			}
			else
			{
				$resize['image_library']    = 'gd2';
				$resize['quality']			= '100%';
				$resize['source_image']     = $uploaded_resource;
				$resize['new_image']        = $new_fullpath;
				$resize['maintain_ratio']   = TRUE;
				$resize['width']            = ($uploaded_data['width'] > $resizing_data['width']) ? $resizing_data['width'] : $uploaded_data['width'];
				$resize['height']           = ($uploaded_data['height'] > $resizing_data['height']) ? $resizing_data['height'] : $uploaded_data['height'];
				$resize['master_dim']       = 'auto';
				if($resizing_data['crop'])
					$resize['master_dim']   = ($uploaded_data['width'] >= $uploaded_data['height']) ? 'height' : 'width';

				$CI->image_lib->initialize($resize);
				$CI->image_lib->resize();

				if($resizing_data['crop'])
				{
					// get image data after resize
					$resized_data = $CI->image_lib->get_image_properties($new_fullpath, TRUE);

					// margins for crop
					$x_axis = ($resized_data['width'] - $resizing_data['width']) / 2;
					$y_axis = ($resized_data['height'] - $resizing_data['height']) / 2;

					$crop['image_library']  = 'gd2';
					$crop['source_image']   = $new_fullpath;
					$crop['maintain_ratio'] = FALSE;
					$crop['quality']			= '100%';
					$crop['width']          = $resizing_data['width'];
					$crop['height']         = $resizing_data['height'];
					$crop['x_axis']         = $x_axis;
					$crop['y_axis']         = $y_axis;

					$CI->image_lib->initialize($crop);
					$CI->image_lib->crop();
				}
			}
        }
    }
}

?>