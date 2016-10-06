<?php

/**
 * Description of tools
 *
 * @author alberto
 */

class Tools extends Admin_controller {
	
	private $_unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

	
	public function __construct() {
		parent::__construct();
	}
	
	private function _retrive_external_data_cycle($list)
	{
		// genero la lista di tabelle di dati esterni ai nodi
		$tables			= $this->drupal->list_tables(); // tutte le tabelle
		$field_tables	= array();						// lista tabelle dati esterni
		
		
		foreach ($tables as $table)
		{
			// salvo nella lista tutte le tabelle di tipo field_data*
			if(strpos($table, 'field_data') !== FALSE)
			{
				$field_tables[] = $table;
			}
		   
		}
		
		foreach($list as $item)
		{
			// cerco dati in ogni tabella dati esterni
			foreach($field_tables as $field_table)
			{
				// inietto i dati dei field custom
				$item->$field_table = $this->drupal->get_where($field_table, array(
					'entity_id' => $item->nid
				))->row();
				
				// se il field è un'immagine carico i dati dell'immagine 
				if((strpos($field_table, 'foto') !== FALSE OR strpos($field_table, 'immagine') !== FALSE OR strpos($field_table, 'logo') !== FALSE OR strpos($field_table, 'image') !== FALSE) AND $item->$field_table)
				{
					$field_str = str_replace('field_data_', '', $field_table) . '_fid';
					
					$item->$field_table->file_managed = $this->drupal->get_where('file_managed', array(
						'fid' => $item->$field_table->$field_str
					))->row();	
				}
				
				if((strpos($field_table, 'img_copertina') !== FALSE AND $item->$field_table))
				{
					$field_str = 'field_img_copertina_fid';
					
					$item->$field_table->file_managed = $this->drupal->get_where('file_managed', array(
						'fid' => $item->$field_table->$field_str
					))->row();	
				}
				
				
				// cerco relazioni con video
				if($field_table == 'field_data_field_azienda_reference_prodotti')
				{
					
					$this->drupal->join('node', 'node.nid = ' . $field_table .'.entity_id');
					$video = $this->drupal->get_where('field_data_field_azienda_reference_prodotti', array('field_azienda_reference_prodotti_target_id' => $item->nid))->row();
					
					$item->related_video = $video;
				}
				
				// cerco relazioni con prodotti
				if($field_table == 'field_data_field_azienda_reference')
				{
					
					$this->drupal->join('node', 'node.nid = ' . $field_table .'.entity_id');
					$products = $this->drupal->get_where('field_data_field_azienda_reference', array('field_azienda_reference_target_id' => $item->nid, 'type' => 'prodotti'))->result();
					
					$item->product_list = $products;
					
					
					foreach($products as $product)
					{
						// immagine
						$this->drupal->select('file_managed.uri');
						$this->drupal->join('file_managed', 'file_managed.fid = field_data_field_immagine_prodotto.field_immagine_prodotto_fid');
						$product->image = $this->drupal->get_where('field_data_field_immagine_prodotto', array('entity_id' => $product->nid))->row();
												
						
						// descrizione
						$this->drupal->select('field_data_body.body_value');
						$product->description = $this->drupal->get_where('field_data_body', array('entity_id' => $product->nid))->row();
					}
				}
				
				
							
				// cerco relazioni con gallery fotografiche
				if(strpos($field_table, 'gallery_fotografica') !== FALSE)
				{
					$this->drupal->select('file_managed.*');
					$this->drupal->join('file_managed', 'file_managed.fid = ' . $field_table .'.field_gallery_fotografica_fid');
					$images = $this->drupal->get_where('field_data_field_gallery_fotografica', array('entity_id' => $item->nid))->result();
					
					$item->$field_table = $images;
				}

				// cerco relazioni con ivdeo
				
				
				// cerco categoria azienda esterna
				if(isset($item->$field_table->field_categoria_azienda_target_id))
				{
					$this->drupal->join('taxonomy_term_hierarchy', 'taxonomy_term_hierarchy.tid = taxonomy_term_data.tid');
					$item->$field_table->taxonomy_term_data = $this->drupal->get_where('taxonomy_term_data', array('taxonomy_term_data.tid' => $item->$field_table->field_categoria_azienda_target_id))->row();
				}
				
				// cerco categoria il_terriorio esterna				
				if($item->type == 'il_territorio' AND isset($item->field_data_field_categorie_del_territoriio))
				{
					$this->drupal->join('taxonomy_term_hierarchy', 'taxonomy_term_hierarchy.tid = taxonomy_term_data.tid');
					$item->field_data_field_categorie_del_territoriio->taxonomy_term_data = $this->drupal->get_where('taxonomy_term_data', array('taxonomy_term_data.tid' => $item->field_data_field_categorie_del_territoriio->field_categorie_del_territoriio_tid))->row();
				}				
				
				// cerco route
				$route = $this->drupal->get_where('url_alias', array('source' => 'node/' . $item->nid))->row();
				if($route)
				{
					$item->slug = strtr($route->alias, $this->_unwanted_array);
				}
				
			}
			
			//vardump($item);
		}
		

		//exit();
		
		return $list;
	}
	
	private function _init_categories()
	{
		// CATEGORIA RADICE AZIENDE
		$category_data = array(
			'name'		=> 'Aziende',
			'parent_id' => 0,
			'published'	=> 1,
			'module'	=> 'products'
		);
		$this->shoppamee->insert('categories',$category_data);
						
		$root_azienda_category_id = $this->shoppamee->insert_id();

		$this->load->model('route_model');

		$route_id = $this->route_model->set_route(url_title($category_data['name'], '-', TRUE), 'front/categories/show/' . $root_azienda_category_id);

		$this->shoppamee->insert('category_contents', array(
			'category_id'	=> $root_azienda_category_id,
			'active'		=> 1,
			'iso'			=> 'it',
			'route_id'		=> $route_id,
			'name'			=> $category_data['name'],
			'description'	=> ''
		));

		
		// CATEGORIA RADICE TERRITORIO
		$category_data = array(
			'name'		=> 'Valle di Susa',
			'parent_id' => 0,
			'published'	=> 1,
			'module'	=> 'pages'
		);
		$this->shoppamee->insert('categories',$category_data);
						
		$root_territorio_category_id = $this->shoppamee->insert_id();

		$this->load->model('route_model');

		$route_id = $this->route_model->set_route(url_title($category_data['name'], '-', TRUE), 'front/categories/show/' . $root_territorio_category_id);

		$this->shoppamee->insert('category_contents', array(
			'category_id'	=> $root_territorio_category_id,
			'active'		=> 1,
			'iso'			=> 'it',
			'route_id'		=> $route_id,
			'name'			=> $category_data['name'],
			'description'	=> ''
		));
		
		
		return array(
			'root_territorio_category_id'	=> $root_territorio_category_id,
			'root_azienda_category_id'		=> $root_azienda_category_id,
			);
	}
	
	private function _insert_page($item)
	{
		// entity
		$this->shoppamee->insert('pages', array(
			'name' => $item->title,
			'published'	=> 1
		));
		$page_id = $this->shoppamee->insert_id();

		// route
		$this->shoppamee->insert('routes', array(
			'slug' => $item->slug,
			'route'	=> 'front/pages/show/' . $page_id
		));
		$route_id = $this->shoppamee->insert_id();		

		// contents
		$this->shoppamee->insert('page_contents', array(
			'page_id'		=> $page_id,
			'active'		=> 1,
			'iso'			=> 'it',
			'title'			=> $item->title,
			'route_id'		=> $route_id,
			'content'		=> $item->field_data_body->body_value
		));
	}
	
	private function _insert_storia($item)
	{
		
		if (preg_match('/src="([^"]+)"/', $item->field_data_field_iframe_video->field_iframe_video_value, $m)) {
			print $m[1];

			$this->shoppamee->insert('videos', array(
				'name' => $item->title,
				'published' => 1,
				'url'	=> $m[1],
				'channel'	=> 'vimeo',
				'lat' => SomeHelper::rand(45.18, 45.08),
				'lng' => SomeHelper::rand(7.31, 6.93)
			));

			$video_id = $this->shoppamee->insert_id();

			$this->shoppamee->insert('video_contents', array(
				'title' => $item->title,
				'active' => 1,
				'iso'		=> 'it',
				'content'	=> $item->field_data_field_imprenditore->field_imprenditore_value,
				'video_id'	=> $video_id
			));


		}
	}
	
	private function _insert_azienda($item, $root_azienda_category_id)
	{
		// category
		$category_data = array(
			'id'		=> $item->field_data_field_categoria_azienda->taxonomy_term_data->tid,
			'name'		=> $item->field_data_field_categoria_azienda->taxonomy_term_data->name,
			'parent_id' => ($item->field_data_field_categoria_azienda->taxonomy_term_data->parent > 0) ? $item->field_data_field_categoria_azienda->taxonomy_term_data->parent : $root_azienda_category_id,
			'published'	=> 1,
			'module'	=> 'products'
		);

		$category_id = $category_data['id'];

		$category = $this->shoppamee->get_where('categories', array('id' => $item->field_data_field_categoria_azienda->taxonomy_term_data->tid))->row('category');

		if( ! $category)
		{
			$this->shoppamee->insert('categories',$category_data);

			$category_id = $this->shoppamee->insert_id();

			$this->load->model('route_model');

			$route_id = $this->route_model->set_route(url_title($category_data['name'], '-', TRUE), 'front/categories/show/' . $category_id);

			$this->shoppamee->insert('category_contents', array(
				'category_id'	=> $category_id,
				'active'		=> 1,
				'iso'			=> 'it',
				'route_id'		=> $route_id,
				'name'			=> $category_data['name'],
				'description'	=> $item->field_data_field_categoria_azienda->taxonomy_term_data->description
			));
		}



		// default image		
		$img_id;
		$file_name	= str_replace('public://', '', $item->field_data_field_img_copertina->file_managed->uri);

		vardump($file_name);

		if(file_exists('../../../laboratoriovalsusa.it/Archibuzz/home/filippo/public_html/laboratoriovalsusa/www.laboratoriovalsusa.it/sites/default/files/' . $file_name))
		{		
			// save remote image
			$images_formats = $this->config->item('images_image_formats');
			$images_formats[] = array('size' => 'upload');

			//$url		= parse_url($data->originalImageUrl, PHP_URL_PATH);  


			$path	= substr($this->config->item('images_upload_path'),2) . $file_name;
			$insert = copy('../../../laboratoriovalsusa.it/Archibuzz/home/filippo/public_html/laboratoriovalsusa/www.laboratoriovalsusa.it/sites/default/files/' . $file_name, $path);

			if($insert)
			{
				$this->load->helper('image_resizer');
				resize_image($file_name, 'images_');


				$this->db->insert('images', array(
					'name'	=> $item->title,
					'src'	=> $file_name
				));

				$img_id = $this->db->insert_id();

				$this->db->insert('image_contents', array(
					'iso'			=> 'it',
					'title'			=> '',
					'description'	=> '',
					'image_id'		=> $img_id
				));
			}
		}

		
		
		


		// entity
		$this->shoppamee->insert('products', array(
			'name' => $item->title,
			'published' => 1,
			'default_image_id' => $img_id,
			'category_id'		=> $category_id,
			'lat' => SomeHelper::rand(45.18, 45.08),
			'lng' => SomeHelper::rand(7.31, 6.93)
		));
		$product_id = $this->shoppamee->insert_id();

		// external image relation
		$this->shoppamee->insert('product_images', array(
			'product_id'	=> $product_id,
			'image_id'		=> $img_id
		));

		// gallery
		if(is_array($item->field_data_field_gallery_fotografica))
		{
			foreach($item->field_data_field_gallery_fotografica as $table_row)
			{
				$curr_img_id;
				$file_name	= str_replace('public://', '', $table_row->uri);

				if(file_exists('../../../laboratoriovalsusa.it/Archibuzz/home/filippo/public_html/laboratoriovalsusa/www.laboratoriovalsusa.it/sites/default/files/' . $file_name))
				{		
					// save remote image
					$images_formats = $this->config->item('images_image_formats');
					$images_formats[] = array('size' => 'upload');

					//$url		= parse_url($data->originalImageUrl, PHP_URL_PATH);  


					$path	= substr($this->config->item('images_upload_path'),2) . $file_name;
					$insert = copy('../../../laboratoriovalsusa.it/Archibuzz/home/filippo/public_html/laboratoriovalsusa/www.laboratoriovalsusa.it/sites/default/files/' . $file_name, $path);

					if($insert)
					{
						$this->load->helper('image_resizer');
						resize_image($file_name, 'images_');


						$this->db->insert('images', array(
							'name'	=> $item->title,
							'src'	=> $file_name
						));

						$curr_img_id = $this->db->insert_id();

						$this->db->insert('image_contents', array(
							'iso'			=> 'it',
							'title'			=> '',
							'description'	=> '',
							'image_id'		=> $curr_img_id
						));
						
						$this->shoppamee->insert('product_images', array(
							'product_id'	=> $product_id,
							'image_id'		=> $curr_img_id,
							'type'			=> 'gallery'
						));
					}
				}
			}
		}
		
		// products
		if(is_array($item->product_list))
		{
			
			foreach($item->product_list as $product_item)
			{
				$product_item_image_id = NULL;
				$file_name	= str_replace('public://', '', $product_item->image->uri);
				
				$insert = FALSE;
				
				if(file_exists('../../../laboratoriovalsusa.it/Archibuzz/home/filippo/public_html/laboratoriovalsusa/www.laboratoriovalsusa.it/sites/default/files/' . $file_name))
				{		
					// save remote image
					$images_formats = $this->config->item('images_image_formats');
					$images_formats[] = array('size' => 'upload');

					//$url		= parse_url($data->originalImageUrl, PHP_URL_PATH);  


					$path	= substr($this->config->item('images_upload_path'),2) . $file_name;
					$insert = copy('../../../laboratoriovalsusa.it/Archibuzz/home/filippo/public_html/laboratoriovalsusa/www.laboratoriovalsusa.it/sites/default/files/' . $file_name, $path);

					if($insert)
					{
						$this->load->helper('image_resizer');
						resize_image($file_name, 'images_');


						$this->db->insert('images', array(
							'name'	=> $product_item->title,
							'src'	=> $file_name
						));

						$product_item_image_id = $this->db->insert_id();

						$this->db->insert('image_contents', array(
							'iso'			=> 'it',
							'title'			=> '',
							'description'	=> '',
							'image_id'		=> $product_item_image_id
						));

					}
				}
				
				$this->shoppamee->insert('product_versions', array(
					'name'			=> $product_item->title,
					'code'			=> $product_item->title,
					'product_id'	=> $product_id,
					'published'		=> 1,
					'default_image_id'	=> $product_item_image_id
					
				));
				
				$product_item_id = $this->shoppamee->insert_id();
				
				if($insert)
				{
					$this->shoppamee->insert('product_version_images', array(
						'version_id'	=> $product_item_id,
						'image_id'		=> $product_item_image_id,
						'type'			=> 'product'
					));
				}
				
				
				$this->shoppamee->insert('product_version_contents', array(
					'version_id'		=> $product_item_id,
					'iso'				=> 'it',
					'active'			=> 1,
					'name'				=> $product_item->title,
					'description'		=> $product_item->description->body_value
				));
						
			
			}
		}
		
		
		// route
		$this->shoppamee->insert('routes', array(
			'slug' => $item->slug,
			'route'	=> 'front/products/show/' . $product_id
		));
		$route_id = $this->shoppamee->insert_id();		

		// contents
		$this->shoppamee->insert('product_contents', array(
			'product_id'		=> $product_id,
			'active'		=> 1,
			'iso'			=> 'it',
			'name'			=> $item->title,
			'route_id'		=> $route_id,
			'description'		=> $item->field_data_field_descrizione->field_descrizione_value
		));
		
		
		//video
		
		$video = $this->shoppamee->get_where('videos', array('name' => $item->related_video->title))->row();
		
		if($video)
		{
			$this->shoppamee->insert('product_videos', array(
				'product_id'	=> $product_id,
				'video_id'		=> $video->id,
				'is_default'	=> 1
			));
		}
		
	}
	
	
	private function _insert_territorio($item, $root_territorio_category_id)
	{
		// category
		$category_data = array(
			'id'		=> $item->field_data_field_categorie_del_territoriio->taxonomy_term_data->tid,
			'name'		=> $item->field_data_field_categorie_del_territoriio->taxonomy_term_data->name,
			'parent_id' => ($item->field_data_field_categorie_del_territoriio->taxonomy_term_data->parent > 0) ? $item->field_data_field_categorie_del_territoriio->taxonomy_term_data->parent : $root_territorio_category_id,
			'published'	=> 1,
			'module'	=> 'pages'
		);

		$category_id = $category_data['id'];

		$category = $this->shoppamee->get_where('categories', array('id' => $item->field_data_field_categorie_del_territoriio->taxonomy_term_data->tid))->row('category');

		if( ! $category)
		{
			$this->shoppamee->insert('categories',$category_data);

			$category_id = $this->shoppamee->insert_id();

			$this->load->model('route_model');

			$route_id = $this->route_model->set_route(url_title($category_data['name'], '-', TRUE), 'front/categories/show/' . $category_id);

			$this->shoppamee->insert('category_contents', array(
				'category_id'	=> $category_id,
				'active'		=> 1,
				'iso'			=> 'it',
				'route_id'		=> $route_id,
				'name'			=> $category_data['name'],
				'description'	=> $item->field_data_field_categorie_del_territoriio->taxonomy_term_data->description
			));
		}



		// default image		
		$img_id;
		$file_name	= str_replace('public://', '', $item->field_data_field_img_copertina->file_managed->uri);

		vardump($file_name);

		if(file_exists('../../../laboratoriovalsusa.it/Archibuzz/home/filippo/public_html/laboratoriovalsusa/www.laboratoriovalsusa.it/sites/default/files/' . $file_name))
		{		
			// save remote image
			$images_formats = $this->config->item('images_image_formats');
			$images_formats[] = array('size' => 'upload');

			//$url		= parse_url($data->originalImageUrl, PHP_URL_PATH);  


			$path	= substr($this->config->item('images_upload_path'),2) . $file_name;
			$insert = copy('../../../laboratoriovalsusa.it/Archibuzz/home/filippo/public_html/laboratoriovalsusa/www.laboratoriovalsusa.it/sites/default/files/' . $file_name, $path);

			if($insert)
			{
				$this->load->helper('image_resizer');
				resize_image($file_name, 'images_');


				$this->db->insert('images', array(
					'name'	=> $item->title,
					'src'	=> $file_name
				));

				$img_id = $this->db->insert_id();

				$this->db->insert('image_contents', array(
					'iso'			=> 'it',
					'title'			=> '',
					'description'	=> '',
					'image_id'		=> $img_id
				));
			}
		}




		// entity
		$this->shoppamee->insert('pages', array(
			'name' => $item->title,
			'published' => 1,
			'default_image_id' => $img_id,
			'category_id'		=> $category_id,
			//'lat' => SomeHelper::rand(45.18, 45.08),
			//'lng' => SomeHelper::rand(7.31, 6.93)
		));
		$page_id = $this->shoppamee->insert_id();

		// external image relation
		$this->shoppamee->insert('page_images', array(
			'page_id'	=> $page_id,
			'image_id'		=> $img_id
		));

		// route
		$this->shoppamee->insert('routes', array(
			'slug' => $item->slug,
			'route'	=> 'front/pages/show/' . $page_id
		));
		$route_id = $this->shoppamee->insert_id();		

		// contents
		$this->shoppamee->insert('page_contents', array(
			'page_id'		=> $page_id,
			'active'		=> 1,
			'iso'			=> 'it',
			'title'			=> $item->title,
			'route_id'		=> $route_id,
			'content'		=> $item->field_data_body->body_value
		));

		


	}
	
	
	private function _insert_news($item)
	{
		$img_id;
		$file_name	= str_replace('public://', '', $item->field_data_field_image->file_managed->uri);

		if(file_exists('../../../laboratoriovalsusa.it/Archibuzz/home/filippo/public_html/laboratoriovalsusa/www.laboratoriovalsusa.it/sites/default/files/' . $file_name))
		{		
			// save remote image
			$images_formats = $this->config->item('images_image_formats');
			$images_formats[] = array('size' => 'upload');

			//$url		= parse_url($data->originalImageUrl, PHP_URL_PATH);  


			$path	= substr($this->config->item('images_upload_path'),2) . $file_name;
			$insert = copy('../../../laboratoriovalsusa.it/Archibuzz/home/filippo/public_html/laboratoriovalsusa/www.laboratoriovalsusa.it/sites/default/files/' . $file_name, $path);

			if($insert)
			{
				$this->load->helper('image_resizer');
				resize_image($file_name, 'images_');


				$this->db->insert('images', array(
					'name'	=> $item->title,
					'src'	=> $file_name
				));

				$img_id = $this->db->insert_id();

				$this->db->insert('image_contents', array(
					'iso'			=> 'it',								
					'title'			=> '',
					'description'	=> '',
					'image_id'		=> $img_id
				));
			}
		}



		// entity
		$this->shoppamee->insert('news', array(
			'name'				=> $item->title,
			'published'			=> 1,
			'date'				=> $item->field_data_field_data_di_pubblicazione->field_data_di_pubblicazione_value,
			'default_image_id'	=> $img_id,
		));
		$news_id = $this->shoppamee->insert_id();

		// route
		$this->shoppamee->insert('routes', array(
			'slug' => $item->slug,
			'route'	=> 'front/news/show/' . $news_id
		));
		$route_id = $this->shoppamee->insert_id();		

		// contents
		$this->shoppamee->insert('news_contents', array(
			'news_id'		=> $news_id,
			'active'		=> 1,
			'iso'			=> 'it',
			'title'			=> $item->title,
			'route_id'		=> $route_id,
			'content'		=> $item->field_data_body->body_value
		));
	}
	
	
	
	
	
	public function import()
	{
	
		
		$this->drupal		= $this->load->database('drupal', TRUE);
		
		
		$this->load->library('import/drupal_node');
		
		$list = $this->drupal->order_by('type', 'desc')->get('node')->result('drupal_node');
		//$list = $this->drupal->get_where('node', array('type' => 'azienda'))->result('drupal_node');
		
		
		// ciclo le tabelle dei dati esterni per appendere ai nodi tutti i dati esterni
		$list = $this->_retrive_external_data_cycle($list);
		
		
		
		// OPEN MANAGEE DB CONNECTION
		$this->shoppamee	= $this->load->database('default', TRUE);
		
		
		// INIT ROOT CATEGORIES
		$root_categories_id = $this->_init_categories();
		
		$root_azienda_category_id		= $root_categories_id['root_azienda_category_id'];
		$root_territorio_category_id	= $root_categories_id['root_territorio_category_id'];
		
		
		
		foreach($list as $item)
		{
			
			
			/**
			 * RAPPRESENTAZIONE TEMPORANEA PER VEDERE I DATI
			 */
			echo '<div style="width:50%; margin:auto;">';
			
				echo '<h1>'.$item->nid . ' - ' . $item->title.'</h1>';
				echo '<h3>'.$item->type.'</h3>';
					
			
			switch($item->type)
			{
				case 'page':
					
					//vardump($item);
					
					$this->_insert_page($item);
					break;
				
				
				case 'storia':
					
					//vardump($item);
					
					$this->_insert_storia($item);
					
					echo '<h4>' .$item->field_data_field_imprenditore->field_imprenditore_value .'</h4>';
					
					echo $item->field_data_field_iframe_video->field_iframe_video_value;
					
					break;
				
				case 'imprenditore':
					// DO NOTHING
					break;
				
				case 'partners':
					
					echo '<a href="' . $item->field_data_field_link->field_link_url . '">' .$item->field_data_field_link->field_link_url . '</a>';
					echo '<img src="http://archibuzz.laboratoriovalsusa.it/sites/default/files/' . $item->field_data_field_logo->file_managed->filename . '">';
					break;
				
				case 'prodotti':
					// da attaccare ai nodi con prodotti
					break;
				
				
				case 'azienda':
					
					//vardump($item);
					
					$this->_insert_azienda($item, $root_azienda_category_id);
					
					break;
				
				
				case 'il_territorio':
					
					//vardump($item);
					//exit();
					
					$this->_insert_territorio($item, $root_territorio_category_id);
					
					break;
				
				case 'slideshow_home_page':
					//vardump($item);
					break;
				
				
				case 'news':
					
					
					//vardump($item);
					
					$this->_insert_news($item);
					
					//default image
					
					//$item->field_data_field_image->file_managed->filename;
					
					
					
					break;
				case 'slideshow_aziende':
					//vardump($item);
					break;
				case 'slideshow_imprenditori':
					//vardump($item);
					break;
				case 'webform':
					//vardump($item);
					break;
				
			}
			echo '<br><br><hr><br><br>';
			
			echo '</div>';
		}
		
		
	}
	
	/*
	public function import_()
	{
		$csv = array_map('str_getcsv', file('data.csv'));
		
		foreach($csv as $data)
		{
			$provincia		= $data[0];
			$regione		= $data[1];
			$sigla			= $data[2];
			
			$db_regione = $this->shoppamee->get_where('categories', array('name' => $regione))->row();
			
			
			
			if( ! $db_regione)
			{
				$this->shoppamee->order_by('ord', 'desc');
				$this->shoppamee->limit(1);
				$last_category = $this->shoppamee->get_where('categories', array('parent_id' => 0))->row();

				$ord = $last_category ? $last_category->ord + 1 : 0;
				
				$this->shoppamee->insert('categories', array(
					'name'		=> $regione,
					'parent_id'	=> 0,
					'ord'		=> $ord,
					'published'	=> 1
				));
				
				$regione_id = $this->shoppamee->insert_id();
				
				$this->shoppamee->insert('routes', array(
					'slug'	=> 'it/' . url_title($regione, '-', TRUE),
					'route'	=> 'front/categories/show/' . $regione_id
				));
				
				$route_id = $this->shoppamee->insert_id();
						
				$this->shoppamee->insert('category_contents', array(
					'category_id'	=> $regione_id,
					'iso'			=> 'it',
					'route_id'		=> $route_id,
					'active'		=> 1,
					'name'			=> $regione
				));
				
			}
			else
			{
				$regione_id = $db_regione->id;
				
				
			}
			
			$this->shoppamee->order_by('ord', 'desc');
			$this->shoppamee->limit(1);
			$last_child = $this->shoppamee->get_where('categories', array('parent_id' => $regione_id))->row();

			$ord = $last_child ? $last_child->ord + 1 : 0;

			$this->shoppamee->insert('categories', array(
				'name'		=> $provincia,
				'parent_id'	=> $regione_id,
				'ord'		=> $ord,
				'published'	=> 1
			));

			$category_id = $this->shoppamee->insert_id();

			$this->shoppamee->insert('routes', array(
				'slug'	=> 'it/' . url_title($provincia, '-', TRUE),
				'route'	=> 'front/categories/show/' . $category_id
			));

			$route_id = $this->shoppamee->insert_id();

			$this->shoppamee->insert('category_contents', array(
				'category_id'	=> $category_id,
				'iso'			=> 'it',
				'route_id'		=> $route_id,
				'active'		=> 1,
				'name'			=> $provincia
			));
		}
	}

	*/
	
	public function geolocalization()
	{
		$this->_view('geolocalization');
	}
	
	public function empty_all_managee_data()
	{
		$tables = array(
			'categories',
			'products',
			'menus',
			'news',
			'pages',
			'offers',
			'professionals',
			'properties',
			'routes',
			'showcases',
			'subscribers',
			'texts',
			'types_products',
			'type_products_groups',
			'versionable_features',
			'videos'
		);
		
		foreach($tables as $table)
		{	
			$this->db->query('DELETE FROM ' . $table);
		}
		
		// delete all images
		$this->load->model('image_model');
		
		foreach($this->image_model->get_all() as $img)
		{
			$this->image_model->delete($img);
		}
		
		
		$this->set_message('success', 'Tutti i dati in database sono stati cancellati con successo!');
		redirect('admin/dashboard');
	}
}