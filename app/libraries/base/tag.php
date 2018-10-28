<?php

class Tag extends Library_model {
	public $id;
	public $name;
	public $ord;

	private $_pages;
	
	protected $_contents_class	= 'Tag_content';
	protected $_model			= 'tag_model';

	function __get($name) {
		return get_instance()->$name;
	}
}

?>