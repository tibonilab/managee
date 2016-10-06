<?php

/**
 * Description of video_content
 *
 * @author Alberto
 */
class Video_content extends Contents {
	public $video_id;
	public $title;
	public $content;
	public $route_id = NULL;
	public $meta_title;
	public $meta_key;
	public $meta_descr;
	public $active = TRUE;
	
	function __construct() {
		parent::__construct();
	}	
	
}

?>
