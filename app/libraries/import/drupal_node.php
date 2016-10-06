<?php
/**
 * Description of drupal_node
 *
 * @author alberto
 */
class Drupal_node {
	
	protected $_fields;
	
	private $_db;
	
	
	public function __construct() {
		//$this->_db = get_instance()->drupal;
	}
	
	public function get_fields()
	{
		if(is_null($this->_fields))
		{

		}
		
		
		return $this->_fields;
	}
	
	
	
	
}
