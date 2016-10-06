<?php

$config['images_images_path']               = './assets/<MY_THEME_NAME>/images/mediagallery/';
$config['images_upload_path']               = $config['images_images_path'] . 'upload/';

// image resizing data
$config['images_image_formats']             = array(
                    array(
                        'size'      => 'big',
                        'width'     => 1000,
                        'height'    => 1000,
                        'crop'      => FALSE
                    ),
					array(
                        'size'      => 'medium',
                        'width'     => 400,
                        'height'    => 400,
                        'crop'      => FALSE
                    ),
                    array(
                        'size'      => 'small',
                        'width'     => 250,
                        'height'    => 200,
                        'crop'      => FALSE
                    ),
                    array(
                        'size'      => 'thumbs',
                        'width'     => 100,
                        'height'    => 100,
                        'crop'      => TRUE
                    ),
                    array(
                        'size'      => 'squared',
                        'width'     => 350,
                        'height'    => 350,
                        'crop'      => TRUE
                    ),
                    array(
                        'size'      => 'showcase',
                        'width'     => 1600,
                        'height'    => 900,
                        'crop'      => TRUE
                    )
                );

// configuration data for image upload library
$config['images_upload_library_config']     = array(
                    'upload_path'       => $config['images_upload_path'],
                    'allowed_types'     => 'gif|jpg|jpeg|png',
                    'max_size'          => '8192'
                );


/* products configuration */ 
$config['products_image_formats']           = $config['images_image_formats'];

$config['products_images_path']             = './assets/front/images/products/';
$config['products_upload_path']             = $config['products_images_path'] . 'upload/';
$config['products_upload_library_config']   = array(
                    'upload_path'       => $config['products_upload_path'],
                    'allowed_types'     => 'gif|jpg|jpeg|png',
                    'max_size'          => '4096'
                );



// configuration data for image upload library
$config['icons_images_path']             = './assets/front/images/icons/';

$config['icons_upload_library_config']     = array(
                    'upload_path'       => $config['icons_images_path'],
                    'allowed_types'     => 'gif|jpg|jpeg|png',
                    'max_size'          => '4096'
                );


?>